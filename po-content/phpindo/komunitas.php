<?php if ($mod==""){
	header('location:../../404.php');
}else{
?>
<!-- 
*******************************************************
	Include Header Template
******************************************************* 
-->
<?php include_once "po-content/$folder/header.php"; ?>


<!-- 
*******************************************************
	Main Content Template
******************************************************* 
-->
		<!-- **Main - Starts** --> 
		<div id="main">
        	<div class="breadcrumb-wrapper type2">
            	<div class="container">
                	<div class="main-title">
                    	<h1>Komunitas</h1>
                        <div class="breadcrumb">
                            <a href="<?=$website_url;?>">Home</a>
                            <span class="fa fa-angle-right"></span>
                            <span class="current">Komunitas</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Primary Starts -->
            <section class="content-full-width">
				<div class="container">
                    <div class="hr-title dt-sc-hr-invisible-small" id='peta' style='height:600px;'>
                        
                    </div>
                </div>
			</section>
        </div> <!-- **Main - Ends** -->
<!-- <link id="reset" rel="stylesheet"  href="<?=$website_url;?>/po-content/<?=$folder;?>/css/reset.css" media="all" /> -->
<link href="http://code.google.com/apis/maps/documentation/javascript/examples/standard.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?=$website_url;?>/po-content/<?=$folder;?>/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript">
var peta;
var titik = [];
function peta_awal(){
    var pekanbaru = new google.maps.LatLng(-2.548926, 118.0148634);
    var petaoption = {
        zoom: 5,
        center: pekanbaru,
        mapTypeId: google.maps.MapTypeId.ROADMAP
        };
    peta = new google.maps.Map(document.getElementById("peta"),petaoption);
    google.maps.event.addListener(peta,'click',function(event){
        OpenForm(event.latLng);
    });

    $.ajax({
        type: "GET",
        dataType: "JSON",
        url: 'komunitas.php?id=data',
        success: function(data)
        {
            for (var i = 0; i < data.length; i++) {
                LokasiKomunitas(data[i]);
                console.log(data[i].nama);
            }
        } 
    });
}
function OpenForm(lokasi){
    for (var i = 0; i < titik.length; i++) {
        titik[i].setMap(null);
    }
    var contentString = '<form method="post" class="" action="<?=$website_url;?>/komunitas.php" id="FormKomunitas">'+
        '<div class="dt-sc-hr-invisible-small no-space"  id="sukses">'+
        '<input type=hidden id="lat" name="lat" value="'+lokasi.lat()+'" size=10>'+
        '<input type=hidden id="lng" name="lng" value="'+lokasi.lng()+'" size=10>'+
            '<div class="column no-space dt-sc-hr-invisible-small">'+
                    '<input type="text" placeholder="Nama *" name="nama" value="" required size="20" />'+
            '</div>'+
            '<div class="column no-space dt-sc-hr-invisible-small">'+
                '<span>'+
                    '<input type="text" placeholder="Alamat *" name="alamat" value="" required size="20" />'+
                '</span>'+
            '</div>'+
            '<div class="column no-space dt-sc-hr-invisible-small">'+
                '<span>'+
                    '<input type="text" placeholder="Email *" name="email" value="" required size="20" />'+
                '</span>'+
            '</div>'+
            '<div class="column no-space dt-sc-hr-invisible-small">'+
                '<span>'+
                    '<input type="text" placeholder="Facebook *" name="facebook" value="" required size="20" />'+
                '</span>'+
            '</div>'+
            '<div class="column no-space dt-sc-hr-invisible-small">'+
                '<span>'+
                    '<input type="text" placeholder="Twitter *" name="twitter" value="" required size="20" />'+
                '</span>'+
            '</div>'+
            '<div class="column no-space dt-sc-five-sixth" id="error">'+
            '</div>'+
            '<div class="column no-space dt-sc-five-sixth">'+
                '<span>'+
                    '<input type="button" value="Kirim" name="submit" onclick="kirim_data();" />'+
                '</span>'+
            '</div>'+
        '</div>'+
        '</form>';
    infoWindow = new google.maps.InfoWindow({
        content: contentString,
        Width: 200
    });
    infoWindow.setPosition(lokasi);
    infoWindow.open(peta);
    titik.push(infoWindow);
}
function LokasiKomunitas(lokasi){
    var lk=lokasi;
    var lok = new google.maps.LatLng(lokasi.lat , lokasi.lng);
    tanda = new google.maps.Marker({
        position: lok,
        map: peta
    });
    google.maps.event.addListener(tanda, 'click', function(lokasi){
        ShowKomunitas(lk);
    });
}
function ShowKomunitas(lokasi) {
    for (var i = 0; i < titik.length; i++) {
        titik[i].setMap(null);
    }
    var contentString = '<div class="dt-sc-hr-invisible-small no-space"  id="sukses">'+
            '<div class="column no-space dt-sc-hr-invisible-small">'+
                    'Nama : '+lokasi.nama+
            '</div>'+
            '<div class="column no-space dt-sc-hr-invisible-small">'+
                '<span>'+
                    'Alamat : '+lokasi.alamat+
                '</span>'+
            '</div>'+
            '<div class="column no-space dt-sc-hr-invisible-small">'+
                '<span>'+
                    'Email : '+lokasi.email+
                '</span>'+
            '</div>'+
            '<div class="column no-space dt-sc-hr-invisible-small">'+
                '<span>'+
                    'Facebook : '+lokasi.facebook+
                '</span>'+
            '</div>'+
            '<div class="column no-space dt-sc-hr-invisible-small">'+
                '<span>'+
                    'Twitter : '+lokasi.twitter+
                '</span>'+
            '</div>'+
        '</div>';
    infoWindow = new google.maps.InfoWindow({
        content: contentString,
        Width: 200
    });
    var lok = new google.maps.LatLng(lokasi.lat , lokasi.lng);
    infoWindow.setPosition(lok);
    infoWindow.open(peta);
    titik.push(infoWindow);
}
function kirim_data() {
  var data_member ="";
  $.ajax({
    type: "POST",
    dataType: "html",
    url: 'komunitas.php?id=add',
    data: $("#FormKomunitas").serialize(),
    success: function(data)
    {
        var dt=data.split(":");
        $("#"+dt[0]).text("");
        $("#"+dt[0]).append(dt[1]);
    } 
  });
}
peta_awal();
</script>
<!-- 
*******************************************************
	Include Footer Template
******************************************************* 
-->
<?php include_once "po-content/$folder/footer.php"; ?>
<?php } ?>