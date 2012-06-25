 <?php

global $wpdb, $mp;
$year = date('Y');
$month = date('m');
$month0 = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");

$year = date('Y', strtotime('-1 months'));
$month = date('m', strtotime('-1 months'));
$month1 = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");	

$year = date('Y', strtotime('-2 months'));
$month = date('m', strtotime('-2 months'));
$month2 = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");	

$year = date('Y', strtotime('-3 months'));
$month = date('m', strtotime('-3 months'));
$month3 = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");	

$year = date('Y', strtotime('-4 months'));
$month = date('m', strtotime('-4 months'));
$month4 = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");	

$year = date('Y', strtotime('-5 months'));
$month = date('m', strtotime('-5 months'));
$month5 = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");	

$year = date('Y', strtotime('-6 months'));
$month = date('m', strtotime('-6 months'));
$month6 = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");	

$year = date('Y', strtotime('-7 months'));
$month = date('m', strtotime('-7 months'));
$month7 = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");	

$year = date('Y', strtotime('-8 months'));
$month = date('m', strtotime('-8 months'));
$month8 = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");	

$year = date('Y', strtotime('-9 months'));
$month = date('m', strtotime('-9 months'));
$month9 = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");	

$year = date('Y', strtotime('-10 months'));
$month = date('m', strtotime('-10 months'));
$month10 = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");	

$year = date('Y', strtotime('-11 months'));
$month = date('m', strtotime('-11 months'));
$month11 = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");	

$year = date('Y', strtotime('-12 months'));
$month = date('m', strtotime('-12 months'));
$month12 = $wpdb->get_row("SELECT count(p.ID) as count, sum(m.meta_value) as total, avg(m.meta_value) as average FROM $wpdb->posts p JOIN $wpdb->postmeta m ON p.ID = m.post_id WHERE p.post_type = 'mp_order' AND m.meta_key = 'mp_order_total' AND YEAR(p.post_date) = $year AND MONTH(p.post_date) = $month");	
	?>
<script type="text/javascript">
google.load('visualization', '1', {packages:['corechart']});
google.setOnLoadCallback(drawChart);
function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Month', 'Orders', 'Total', 'Average'],
    ['0','    ($month0->count); ?>, <?php ($month0->total); ?>, <?php ($month0->average); ?>],
    ['1', <?php ($month1->count); ?>, <?php ($month1->total); ?>, <?php ($month1->average); ?>],
    ['2', <?php ($month2->count); ?>, <?php ($month2->total); ?>, <?php ($month2->average); ?>],
    ['3', <?php ($month3->count); ?>, <?php ($month3->total); ?>, <?php ($month3->average); ?>],
    ['4', <?php ($month4->count); ?>, <?php ($month4->total); ?>, <?php ($month4->average); ?>],
    ['5', <?php ($month5->count); ?>, <?php ($month5->total); ?>, <?php ($month5->average); ?>],
    ['6', <?php ($month6->count); ?>, <?php ($month6->total); ?>, <?php ($month6->average); ?>],
    ['7', <?php ($month7->count); ?>, <?php ($month7->total); ?>, <?php ($month7->average); ?>],
    ['8', <?php ($month8->count); ?>, <?php ($month8->total); ?>, <?php ($month8->average); ?>],
    ['9', <?php ($month9->count); ?>, <?php ($month9->total); ?>, <?php ($month9->average); ?>],
    ['10', <?php ($month10->count); ?>, <?php ($month10->total); ?>, <?php ($month10->average); ?>],
    ['11', <?php ($month11->count); ?>, <?php ($month11->total); ?>, <?php ($month11->average); ?>],
    ['12', <?php ($month12->count); ?>, <?php ($month12->total); ?>, <?php ($month12->average); ?>]
  ]);

  var options = {
    title: 'Store Statistics'); ?>',
    hAxis: {title: 'Year', titleTextStyle: {color: 'red'}}
  };

  var chart = new google.visualization.ColumnChart(document.getElementById('store_stats_chart'));
  chart.draw(data, options);
}
</script>    

<div id="store_stats_chart" style="width: 100%; height: 500px;"></div>
