<?php
	$tgl2=date("Y-m-d");
	$tgl_bawah2 = strtotime("-1 week +1 day",strtotime($tgl2));
	$hasil_tgl_bawah2 = date('Y-m-d', $tgl_bawah2);
	$tablestat = new PoTable('traffic');
    for ($i=3; $i <= 3; $i++){
      $tgl_pengujung = strtotime("+$i day",strtotime($hasil_tgl_bawah2));
      $hasil_tgl_pengujung = date('Y-m-d', $tgl_pengujung);
	  $currentStat3 = $tablestat->findStat(tanggal, $hasil_tgl_pengujung, ip);
    }
    for ($i=4; $i <= 4; $i++){
      $tgl_pengujung = strtotime("+$i day",strtotime($hasil_tgl_bawah2));
      $hasil_tgl_pengujung = date('Y-m-d', $tgl_pengujung);
	  $currentStat4 = $tablestat->findStat(tanggal, $hasil_tgl_pengujung, ip);
    }
    for ($i=5; $i <= 5; $i++){
      $tgl_pengujung = strtotime("+$i day",strtotime($hasil_tgl_bawah2));
      $hasil_tgl_pengujung = date('Y-m-d', $tgl_pengujung);
	  $currentStat5 = $tablestat->findStat(tanggal, $hasil_tgl_pengujung, ip);
    }
    for ($i=6; $i <= 6; $i++){
      $tgl_pengujung = strtotime("+$i day",strtotime($hasil_tgl_bawah2));
      $hasil_tgl_pengujung = date('Y-m-d', $tgl_pengujung);
	  $currentStat6 = $tablestat->findStat(tanggal, $hasil_tgl_pengujung, ip);
    }
?>

<?php
	$tgl3=date("Y-m-d");
	$tgl_bawah3 = strtotime("-1 week +1 day",strtotime($tgl3));
	$hasil_tgl_bawah3 = date('Y-m-d', $tgl_bawah3);
	$tablestatd = new PoTable('traffic');
    for ($i3=3; $i3 <= 3; $i3++){
      $tgl_hits = strtotime("+$i3 day",strtotime($hasil_tgl_bawah3));
      $hasil_tgl_hits = date('Y-m-d', $tgl_hits);
	  $hasil_tgl_hits1 = date('d-m-Y', $tgl_hits);
	  $sql_hits = $tablestatd->findStatd(hits, hitstoday, tanggal, $hasil_tgl_hits, tanggal);
	  if ($sql_hits==''){
		$sql_hits3='0';
	  }else{
		$sql_hits3=$sql_hits;
	  }
    }
    for ($i3=4; $i3 <= 4; $i3++){
      $tgl_hits = strtotime("+$i3 day",strtotime($hasil_tgl_bawah3));
      $hasil_tgl_hits = date('Y-m-d', $tgl_hits);
	  $hasil_tgl_hits2 = date('d-m-Y', $tgl_hits);
	  $sql_hits = $tablestatd->findStatd(hits, hitstoday, tanggal, $hasil_tgl_hits, tanggal);
	  if ($sql_hits==''){
		$sql_hits4='0';
	  }else{
		$sql_hits4=$sql_hits;
	  }
    }
    for ($i3=5; $i3 <= 5; $i3++){
      $tgl_hits = strtotime("+$i3 day",strtotime($hasil_tgl_bawah3));
      $hasil_tgl_hits = date('Y-m-d', $tgl_hits);
	  $hasil_tgl_hits3 = date('d-m-Y', $tgl_hits);
	  $sql_hits = $tablestatd->findStatd(hits, hitstoday, tanggal, $hasil_tgl_hits, tanggal);
	  if ($sql_hits==''){
		$sql_hits5='0';
	  }else{
		$sql_hits5=$sql_hits;
	  }
    }
    for ($i3=6; $i3 <= 6; $i3++){
      $tgl_hits = strtotime("+$i3 day",strtotime($hasil_tgl_bawah3));
      $hasil_tgl_hits = date('Y-m-d', $tgl_hits);
	  $hasil_tgl_hits4 = date('d-m-Y', $tgl_hits);
	  $sql_hits = $tablestatd->findStatd(hits, hitstoday, tanggal, $hasil_tgl_hits, tanggal);
	  if ($sql_hits==''){
		$sql_hits6='0';
	  }else{
		$sql_hits6=$sql_hits;
	  }
    }
?>

<script type="text/javascript">
$(document).ready(function () {
	function o(o, i) {
		return Math.floor(Math.random() * (i - o + 1)) + o
	}
	function i() {
		for (g.length > 0 && (g = g.slice(1)); g.length < 300;) {
			var o = g.length > 0 ? g[g.length - 1] : 50,
				i = o + 10 * Math.random() - 5;
				0 > i && (i = 0), i > 100 && (i = 100), g.push(i)
		}
		for (var t = [], l = 0; l < g.length; ++l) t.push([l, g[l]]);
			return $("#chart-live-info").html(i.toFixed(0) + "%"), t
		}
	function t() {
		n.setData([i()]), n.draw(), setTimeout(t, 60)
	}
    var visitors = [[1, <?=$currentStat3;?>], [2, <?=$currentStat4;?>], [3, <?=$currentStat5;?>], [4, <?=$currentStat6;?>]];
    var hits = [[1, <?=$sql_hits3;?>], [2, <?=$sql_hits4;?>], [3, <?=$sql_hits5;?>], [4, <?=$sql_hits6;?>]];
	var tanggal = [[1, "<?=$hasil_tgl_hits1;?>"], [2, "<?=$hasil_tgl_hits2;?>"], [3, "<?=$hasil_tgl_hits3;?>"], [4, "<?=$hasil_tgl_hits4;?>"]];
	var e = $("#chart-classic");
    $.plot(e, [{
		data: visitors, 
		label: "&nbsp;&nbsp;Visitors",
		lines: {
			show: !0,
			fill: !0,
			fillColor: {
				colors: [{
					opacity: .25
				}, {
					opacity: .25
				}]
			}
		},
		points: {
			show: !0,
			radius: 6
		}
	}, { 
		data: hits, 
		label: "&nbsp;&nbsp;Hits",
		lines: {
			show: !0,
			fill: !0,
			fillColor: {
				colors: [{
					opacity: .15
				}, {
				opacity: .15
				}]
			}
		},
		points: {
			show: !0,
			radius: 6
		}
	}],
	{
		colors: ["#3498db", "#333333"],
		legend: {
			show: !0,
			position: "nw",
			margin: [15, 10]
		},
		grid: {
			borderWidth: 0,
			hoverable: !0,
			clickable: !0
		},
		yaxis: {
			tickColor: "#eeeeee"
		},
		xaxis: {
			ticks: tanggal,
			tickColor: "#ffffff"
		}
	});
	var u = null,
		x = null;
	e.bind("plothover", function (o, i, t) {
		if (t) {
			if (u !== t.dataIndex) {
				u = t.dataIndex, $("#chart-tooltip").remove();
				var l = (t.datapoint[0], t.datapoint[1]);
				x = 1 === t.seriesIndex ? "<strong>" + l + "</strong> Hits" : "<strong>" + l + "</strong> Visitors", $('<div id="chart-tooltip" class="chart-tooltip">' + x + "</div>").css({
					top: t.pageY - 45,
					left: t.pageX + 5
				}).appendTo("body").show()
			}
		} else $("#chart-tooltip").remove(), u = null
	})
});
</script>