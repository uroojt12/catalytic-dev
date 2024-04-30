<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= $page_title  ?></title>


	<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/commonCss.css">
<link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/main.css?v=<?=$site_settings->site_version?>">

<style>
	/*
|----------------------------------------------------------------------
|       Oops 404
|----------------------------------------------------------------------
*/
#oops {
	position: fixed;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background: #020406;
	padding: 2rem 0 4rem;
	overflow: auto;
	height: 100vh;
	display: flex;
	align-items: center;
	justify-content: center;
	flex-direction: column;
}

#oops .inner {
	max-width: 34rem;
	margin: 0 auto;
}

#oops .icon {
	color: #fdcc05;
	font-size: 12rem;
	font-weight: 700;
	line-height: 0.8;
	margin-bottom: 2.5rem;
}
</style>

</head>
<body>


<main common 404>



<section id="oops">
	<div class="logo_const">
		<a href="<?= site_url() ?>"><img src="<?= SITE_IMAGES . '/images/' . $site_settings->site_logo . '?v-' . $site_settings->site_version ?>" alt="" ></a>
	</div>
	<div class="contain text-center">
		<div class="icon">Under Construction</div>
		<div class="inner">
			<h4>We Will be Back in short</h4>
			<p>Something new is comming soon</p>
			<!-- <div class="bTn"><a href="<?= site_url() ?>" class="webBtn">Back to the website</a></div> -->
		</div>
	</div>
</section>
<!-- oops -->


</main>


</body>
</html>