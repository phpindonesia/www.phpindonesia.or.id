<?php
/*
 * vim: set ts=3
 *
 * Date: 21th September 2007
 * Name: PostgreSQL Backup n' Restore 1.0
 * Filename: pgBackupRestore.class.php
 * Author: Michele Brodoloni <michele@xtnet.it>
 *
 * --[ DESCRIPTION ]--
 *
 * This class allows you to perform a Backup and Restore process
 * of a PostgreSQL database. It also includes some methods
 * which can be used to query the database and manage the
 * retrieved data.
 *
 * --[ DISCLAIMER ]--
 *
 * This class is provided AS-IS and since it's *NOT FULLY TESTED*
 * it should be not included on a production system.
 *
 * - If you use my class, i would appreciate your feedback
 * - If you find an error, you're invited to report it to me,
 *   with information on how to reproduce it.
 * - If you got the solution for the error you found, or for one
 *   listen in the "PROBLEMS AND KNOWN ISSUES" section, 
 *   you *MUST* report it to me.
 * - Questions and suggestions are always welcome!
 *
 * --[ BENCHMARK INFORMATION ]--
 *
 * This test has been made using a Linux Debian 4.0 box
 * with PostgreSQL v8.1 and PHP 4.4.4-8+etch4, 
 * on an Intel Celeron 1GHz with 128 megabytes(!) of RAM.
 *
 * A database with 51 tables and nearly 40000 records was used.
 * A full backup and restore (including tables' data) has been done.
 * PHP memory limit was set to 32M. I didn't try to lower this value.
 *
 * >> Time to perform backup: 74 seconds
 * >> Time to perform restore: 228 seconds 
 *
 * --[ PROBLEMS AND KNOWN ISSUES ]--
 *
 * - This class was LIGHTLY tested
 * - SEQUENCE creation code may have not be written in the right way.
 * - Unknown behaviour when SEQUENCES are created using SERIALs
 * - Can't find a mysql-like IF EXIST statement when using DROP TABLE
 * - Should i use COPY instead of INSERT? (ref: http://www.postgresql.org/docs/techdocs.15)
 * - Error handling could be improved
 * - Something else i don't remember at the moment ;-)
 *
 * --[ ADDITIONAL NOTES ]--
 *
 * I would say thanks to the guy who wrote the script i found on:
 * http://www.weberdev.com/get_example-4282.html
 *
 * This class has been developed following this procedural example,
 * and improved (as the best as i can) fixing missing things such as
 * indexes and sequence re-creation.
 * 
 */

class pgBackupRestore
{
   //------------------------------------//
   //---[  Configuration variables   ]---//
   //---| SET THEM FROM YOUR SCRIPT  |---//
   //------------------------------------//
   
   // Remove comments from SQL file (commentSQL())
   var $StripComments = false;

   // Include table names into INSERT statement
   var $UseCompleteInsert = false;

   // Drop the table before re-creating it
   var $UseDropTable = true;

   // Dump table structure only, not data
   var $StructureOnly = false;

   // Script keeps running after encountering a fatal error
   var $IgnoreFatalErrors = false;

   //------------------------------------//
   //---| NO NEED TO EDIT BELOW HERE |---//
   //------------------------------------//

   //---[ File related variables
   var $fpSQL;
   var $Filename;

   //---[ Database related variables   
   var $Connected = false;
   var $Database;
   var $Link_ID;
   var $Query_ID;
   var $Record = array();
   var $Tables = array();
   var $BackupOnlyTables = array();
   var $ExcludeTables = array();
   var $Row = 0;

   //---[ Error Handling
   var $GotSQLerror = false;
   var $LastSQLerror = "";

   //---[ Protected keywords
   var $pKeywords = array("desc");

   # CLASS CONSTRUCTOR
   function pgBackupRestore($uiHost, $uiUser, $uiPassword, $uiDatabase, $uiPort = 5432)
   {
      $this->Link_ID = pg_pconnect("host=${uiHost} port=${uiPort} dbname=${uiDatabase} user=${uiUser} password=${uiPassword}");
      $this->Database = $uiDatabase;
      $this->Connected = ($this->Link_ID) ? true : false;
   }

   #------------------------#
   # SQL RELATIVE FUNCTIONS #
   #------------------------#
   
   // Queries the PostgreSQL database.
   // If a SQL error is encountered it will be written on 
   // $this->LastSQLerror variable and $this->GotSQLerror 
   // will be set to TRUE. Returns the query id.
   //
   function query($uiSQL)
   {
      if (!$this->Connected) return (false);
      $this->Row = 0;
      $this->Query_ID = @pg_query($this->Link_ID, $uiSQL);
      $this->LastSQLerror = trim(str_replace("ERROR:", "", pg_last_error($this->Link_ID)));
      $this->GotSQLerror = ($this->LastSQLerror) ? true : false;
      return $this->Query_ID;
   }

   // Returns the next record of a query resultset.
   // Values can be accessed through $this->Record[field_name]
   // or by $this->Record[field_id] (see pg_fetch_array())
   //
   function next_record()
   {
      if (!$this->Query_ID) return (false);

      $this->Record = @pg_fetch_array($this->Query_ID, $this->Row++);
      if (is_array($this->Record)) 
         return(true);
      else 
      {      
         pg_free_result($this->Query_ID);
         $this->Query_ID = 0;
         return(false);
      }
   }

   // Returns a value from a record.
   // Just pass the wanted field name to this.
   //
   function get($uiField)
   {
      if (is_array($this->Record) && array_key_exists($uiField, $this->Record))
         return $this->Record[$uiField];
      else
         return (NULL);
   }
   
   // Returns an array containing the field names
   // returned by a query. 
   // Useful when doing a "SELECT * FROM table" query
   //
   function field_names()
   {
      if (!$this->Query_ID) return(false);
      $n = @pg_num_fields($this->Query_ID);
      $columns = Array();

      for ($i=0; $i<$n ; $i++ )
         $columns[] = @pg_field_name($this->Query_ID, $i);

      return $columns;
   }

   // Return a quoted string if the $this->pKeywords array
   // contains it. It is used when a table name match
   // a PostgreSQL keyword such as "DESC", "PRIMARY"
   // and others, causing a SQL syntax error when restoring
   //
   function escape_keyword($uiKeyword)
   {
      if (in_array($uiKeyword, $this->pKeywords))
         return('"'.$uiKeyword.'"');
      else
         return($uiKeyword);
   }

   #--------------------------#
   # CLASS RELATIVE FUNCTIONS #
   #--------------------------#
   
   // Writes text into the SQL file
   // Called within $this->Backup() method.
   //
   function writeSQL($uiString)
   {
      if (!$this->fpSQL) return(false);
      fwrite($this->fpSQL, $uiString);
   }

   // Writes comments into the SQL file when
   // $this->StripComments is set to FALSE
   // Called within $this->Backup() method.
   // 
   function commentSQL($uiComment)
   {
      if (!$this->fpSQL) return(false);

      if (!$StripComments)
         $this->writeSQL("-- $uiComment");
   }

   // Creates a SQL file containing structure, data, indexes
   // relationships, sequences and so on..
   //
   function Backup($uiFilename = NULL)
   {
      if (!$this->Connected) return (false);

      if (is_null($uiFilename))
         $this->Filename = $this->Database.".sql";
      else
         $this->Filename = $uiFilename;

      //---[ PASS 1: Opening SQL File for writing
   
      $this->fpSQL = @fopen($this->Filename, "w");
      if (!$this->fpSQL) return(false);
       
      //---[ PASS 2: Obtaining table list from database
   
      // If the tables array is not empy, it means that
      // the method $this->BackupOnlyTables was used
      if (empty($this->Tables))
      {
         $SQL = "SELECT relname AS tablename\n".
                "FROM pg_class WHERE relkind IN ('r')\n".
                "AND relname NOT LIKE 'pg_%' AND relname NOT LIKE 'sql_%' ORDER BY tablename\n";
         $this->query($SQL);
     
         // Checks if the current table is in the exclude array. 
         while ($this->next_record())
         {
            $Table = $this->get("tablename");
            if (!in_array($Table, $this->ExcludeTables))
               $this->Tables[] = $this->escape_keyword($Table);
         }
      } 
  
      //---[ PASS 3: Generating structure for each table
      foreach($this->Tables as $Table)
      {
         $_sequences = array();

         $this->commentSQL("Structure for table '${Table}'\n");

         // Use DROP TABLE statement before INSERT ?
         if ($this->UseDropTable)
            $this->writeSQL("DROP TABLE ${Table} CASCADE;\n");

         $strSQL .= "CREATE TABLE ${Table} (";
         
         $SQL = "SELECT attnum, attname, typname, atttypmod-4 AS atttypmod, attnotnull, atthasdef, adsrc AS def\n".
                "FROM pg_attribute, pg_class, pg_type, pg_attrdef\n".
                "WHERE pg_class.oid=attrelid\n".
                "AND pg_type.oid=atttypid AND attnum>0 AND pg_class.oid=adrelid AND adnum=attnum\n".
                "AND atthasdef='t' AND lower(relname)='${Table}' UNION\n".
                "SELECT attnum, attname, typname, atttypmod-4 AS atttypmod, attnotnull, atthasdef, '' AS def\n".
                "FROM pg_attribute, pg_class, pg_type WHERE pg_class.oid=attrelid\n".
                "AND pg_type.oid=atttypid AND attnum>0 AND atthasdef='f' AND lower(relname)='${Table}'\n";

         $this->query($SQL);
         while ( $this->next_record() )
         {
            $_attnum     = $this->get('attnum');
            $_attname    = $this->escape_keyword( $this->get('attname') );
            $_typname    = $this->get('typname');
            $_atttypmod  = $this->get('atttypmod'); 
            $_attnotnull = $this->get('attnotnull');
            $_atthasdef  = $this->get('atthasdef');
            $_def        = $this->get('def');     

            if (eregi("^nextval", $_def))
            {
               $_t = explode("'", $_def);
               $_sequences[] = $_t[1];
            }

            $strSQL .= "${_attname} ${_typname}";
            if ($_typname == "varchar") $strSQL .= "(${_atttypmod})";
            if ($_attnotnull == "t")    $strSQL .= " NOT NULL";
            if ($_atthasdef == "t")     $strSQL .= " DEFAULT ${_def}";
            $strSQL .= ","; 
         }
         $strSQL  = rtrim($strSQL, ",");
         $strSQL .= ");\n";

         //--[ PASS 3.1: Creating sequences
         if ($_sequences)
         {
            foreach($_sequences as $_seq_name)
            {
               $SQL = "SELECT * FROM ${_seq_name}\n";
               $this->query($SQL);
               $this->next_record();
               
               $_incrementby = $this->get('increment_by');
               $_minvalue    = $this->get('min_value');
               $_maxvalue    = $this->get('max_value');
               $_lastvalue   = $this->get('last_value');
               $_cachevalue  = $this->get('cache_value');

               $this->writeSQL("CREATE SEQUENCE ${_seq_name} INCREMENT ${_incrementby} MINVALUE ${_minvalue} ".
                               "MAXVALUE ${_maxvalue} START ${_lastvalue} CACHE ${_cachevalue};\n");
            }
         }

         $this->writeSQL($strSQL);

         if (!$this->StructureOnly)
         {       
            //---[ PASS 4: Generating INSERTs for data
            $this->commentSQL("Data for table '${Table}'\n");
         
            $SQL = "SELECT * FROM ${Table}\n";
            $this->query($SQL);
            while ( $this->next_record() )
            {
               $Record = array();
               $fields = $this->field_names();
               foreach($fields as $f)
               {
                  $data = str_replace("\x0a","",$this->get($f));
                  $data = str_replace("\x0d","\r",$data);
                  $Record[$f] = pg_escape_string(trim($data));
               }
               $FieldNames = ($this->UseCompleteInsert) ?  "(".implode(",",$fields).")" : "";
               
               $strSQL = "INSERT INTO ${Table}${FieldNames} VALUES({". (implode("},{",$fields))."});";
               
               foreach($fields as $f)
               {
                  $str = ($Record[$f] != '') ? "'".$Record[$f]."'" : "NULL";
                  $strSQL = str_replace("{".$f."}", $str, $strSQL);
               }
               $this->writeSQL($strSQL."\n");
               unset($strSQL);
            }
         }
            //---[ PASS 5: Generating data indexes (Primary)
            $this->commentSQL("Indexes for table '${Table}'\n");

            $SQL = "SELECT pg_index.indisprimary, pg_catalog.pg_get_indexdef(pg_index.indexrelid)\n".
                   "FROM pg_catalog.pg_class c, pg_catalog.pg_class c2, pg_catalog.pg_index AS pg_index\n".
                   "WHERE c.relname = '${Table}'\n".
                   "AND c.oid = pg_index.indrelid\n".
                   "AND pg_index.indexrelid = c2.oid\n";
            $this->query($SQL);
            while ( $this->next_record() )
            {
               $_pggetindexdef = $this->get('pg_get_indexdef');
               $_indisprimary = $this->get('indisprimary');

               if (eregi("^CREATE UNIQUE INDEX", $_pggetindexdef))
               {
                  $_keyword = ($_indisprimary == 't') ? 'PRIMARY KEY' : 'UNIQUE';
                  $strSQL = str_replace("CREATE UNIQUE INDEX", "" , $this->get('pg_get_indexdef'));
                  $strSQL = str_replace("USING btree", "|", $strSQL);
                  $strSQL = str_replace("ON", "|", $strSQL);
                  $strSQL = str_replace("\x20","", $strSQL);
                  list($_pkey, $_tablename, $_fieldname) = explode("|", $strSQL);
                  $this->writeSQL("ALTER TABLE ONLY ${_tablename} ADD CONSTRAINT ${_pkey} ${_keyword} ${_fieldname};\n");
                  unset($strSQL);
               } 
               else $this->writeSQL("${_pggetindexdef};\n");
            }
            
            //---[ PASS 6: Generating relationships
            $this->commentSQL("Relationships for table '${Table}'\n");
         
            $SQL = "SELECT cl.relname AS table, ct.conname, pg_get_constraintdef(ct.oid)\n".
                   "FROM pg_catalog.pg_attribute a\n".
                   "JOIN pg_catalog.pg_class cl ON (a.attrelid = cl.oid AND cl.relkind = 'r')\n".
                   "JOIN pg_catalog.pg_namespace n ON (n.oid = cl.relnamespace)\n".
                   "JOIN pg_catalog.pg_constraint ct ON (a.attrelid = ct.conrelid AND ct.confrelid != 0 AND ct.conkey[1] = a.attnum)\n".
                   "JOIN pg_catalog.pg_class clf ON (ct.confrelid = clf.oid AND clf.relkind = 'r')\n".
                   "JOIN pg_catalog.pg_namespace nf ON (nf.oid = clf.relnamespace)\n".
                   "JOIN pg_catalog.pg_attribute af ON (af.attrelid = ct.confrelid AND af.attnum = ct.confkey[1]) order by cl.relname\n";
            $this->query($SQL);
            while ( $this->next_record() )
            {
               $_table   = $this->get('table');
               $_conname = $this->get('conname');
               $_constraintdef = $this->get('pg_get_constraintdef');
               $this->writeSQL("ALTER TABLE ONLY ${_table} ADD CONSTRAINT ${_conname} ${_constraintdef};\n");
            }
         
      }
      //---[ PASS 7: Closing SQL File
      fclose($this->fpSQL);

      return (filesize($this->Filename) > 0)? true : false;
   }

   // Restore the database from a SQL file
   //
   function Restore($uiFilename = NULL)
   {
      $this->Errors = array();
      if (!$this->Connected) return(false);
      if (is_null($uiFilename)) return(false);

      if (!is_readable($uiFilename))
         $this->Error("Can't find $uiFilename for opening", true);

      $_CurrentLine = 0;
      $_fpSQL = fopen($uiFilename, "r");
      while ( $_readSQL = fgets($_fpSQL) )
      {
         $_CurrentLine++;
         if (eregi("^-", $_readSQL)) continue; // Don't bother about comments
         $this->query(utf8_encode($_readSQL));
         if ($this->GotSQLerror)
            $this->Error("SQL syntax error on line ${_CurrentLine} (". $this->LastSQLerror .")", true);
      }
   }

   // Use this method when you don't need to backup
   // some specific tables. The passed value can
   // be a string or an array.
   //
   function ExcludeTables($uiTables)
   {
      if (empty($uiTables)) return(false);

      if (is_array($uiTables))
         foreach ($uiTables as $item)
            $this->ExcludeTables[] = $item;
      else
         $this->ExcludeTables[] = $uiTables; 
   } 

   // Use this methon when you need to backup
   // ONLY some specific tables. The passed value
   // can be a string or an array.
   //
   function BackupOnlyTables($uiTables)
   {
      if (empty($uiTables)) return(false);

      if (is_array($uiTables))
         foreach ($uiTables as $item)
            $this->Tables[] = $item;
      else
         $this->Tables[] = $uiTables;
   }

   // Error printing function.
   // When outputting a fatal error it will exit the script.
   // php-cli coloured output included ;)
   //
   function Error($uiErrStr, $uiFatal = false)
   {
      $_error = "";
      $_error_type = ($uiFatal) ? "Fatal Error" : "Error";
      
      if ($_SERVER['TERM']) // we're using php-cli
         printf("%c[%d;%d;%dm%s: %c[%dm%s\n", 0x1B, 1, 31, 40, $_error_type, 0x1B, 0, $uiErrStr);
      else
         printf("<font face='tahoma' size='2'><b>%s:</b>%nbsp;%s</font><br>\n", $_error_type, $uiErrStr);

      if ($uiFatal && !$this->IgnoreFatalErrors) exit;
   }
}
?>
