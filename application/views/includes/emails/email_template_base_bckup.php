<!DOCTYPE html>
<html lang="en">
	<head>
		<title>TEST</title>
	</head>
	<body>
		<div
			style="
			max-width: 700px;
			padding: 20px;
			border-radius: 5px;
			margin: 40px auto;
			font-family: Open Sans, Helvetica, Arial;
			color: #ffffff;
			"
		>
            <?php echo $email_body?>
			<div style="background: #1355ff; color: #fff; padding: 20px 30px">
				<div>
                    <a href="<?=$site_settings->site_domain?>" style="display: inline-block;">
                        <img src="<?= !empty($site_settings->site_thumb) ? get_site_image_src('images', $site_settings->site_thumb) : 'http://placehold.it/700x620' ?>" alt="<?= $site_settings->site_name ?> Logo" style="height: 50px" align="left">
                    </a>
				</div>
				<div>
					<div class="social_logon">
						<a href="<?=$site_settings->site_facebook?>" target="_blank" rel="noreferrer">
							<img
								src="<?=$site_settings->site_domain?>api/uploads/social_icons/facebook.png"
								alt="facebook icon"
							/>
						</a>
						<a href="<?=$site_settings->site_linkedin?>" target="_blank" rel="noreferrer">
							<img
								src="<?=$site_settings->site_domain?>api/uploads/social_icons/linkedin.png"
								alt="linkedin icon"
							/>
						</a>
						<a href="<?=$site_settings->site_twitter?>" target="_blank" rel="noreferrer">
							<img
								src="<?=$site_settings->site_domain?>api/uploads/social_icons/twitter.png"
								alt="twitter icon"
							/>
						</a>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
