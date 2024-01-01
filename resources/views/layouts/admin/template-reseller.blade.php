<!doctype html>
<html lang="en" dir="ltr">
	<head>

		<!-- META DATA -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Noa – Bootstrap 5 Admin & Dashboard Template">
		<meta name="author" content="Spruko Technologies Private Limited">
		<meta name="keywords" content="admin,admin dashboard,admin panel,admin template,bootstrap,clean,dashboard,flat,jquery,modern,responsive,premium admin templates,responsive admin,ui,ui kit.">
		<!-- FAVICON -->
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('smooth/images/logo-new.png') }}" />

		<!-- TITLE -->
		<title>Smoooth - Reseller</title>

		<!-- BOOTSTRAP CSS -->
		<link id="style" href="{{ asset('asset_admin/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

		<!-- STYLE CSS -->
		<link href="{{ asset('asset_admin/css/style.css') }}" rel="stylesheet"/>
		<link href="{{ asset('asset_admin/css/skin-modes.css') }}" rel="stylesheet" />

		<link href="{{ asset('asset_admin/css/animated.css') }}" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<!--- FONT-ICONS CSS -->
		<link href="{{ asset('asset_admin/css/icons.css') }}" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <style>
            .upload-container {
            text-align: center;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            }

            .upload-label {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            }

            .upload-input {
            display: none;
            }

            /* Styling saat input dipilih */
            .upload-input + label {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            }

            .upload-input + label:hover {
            background-color: #0056b3;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	</head>

	<body class="ltr app sidebar-mini light-mode">
		<!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="{{ asset('asset_admin/images/loader.svg') }}" class="loader-img" alt="Loader">
		</div>
		<!-- /GLOBAL-LOADER -->

		<!-- PAGE -->
		<div class="page">
			<div class="page-main">

				<!-- app-Header -->
				<div class="app-header header sticky">
					<div class="container-fluid main-container">
						<div class="d-flex">
							<a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="#"></a>
							<!-- sidebar-toggle-->
							<a class="logo-horizontal lnr-text-center" href="{{ url('/dashboard') }}">
                                <center>
                                    <img src="{{ asset('smooth/images/logo-single.png') }}" style="background-color: white;" alt="" width="170px">
                                </center>
							<!-- LOGO -->
							<div class="d-flex order-lg-2 ms-auto header-right-icons">
								<div class="dropdown d-xl-none d-md-block d-none">
									<a href="#" class="nav-link icon" data-bs-toggle="dropdown">
										<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path fill="" d="M21.2529297,17.6464844l-2.8994141-2.8994141c-0.0021973-0.0021973-0.0043945-0.0043945-0.0065918-0.0065918c-0.8752441-0.8721313-2.2249146-0.9760132-3.2143555-0.3148804l-0.8467407-0.8467407c1.0981445-1.2668457,1.7143555-2.887146,1.715332-4.5747681c0.0021973-3.8643799-3.1286621-6.9989014-6.993042-7.0011597S2.0092773,5.1315308,2.007019,8.9959106S5.1356201,15.994812,9,15.9970703c1.6889038,0.0029907,3.3114014-0.6120605,4.5789185-1.7111206l0.84729,0.84729c-0.6630859,0.9924316-0.5566406,2.3459473,0.3208618,3.2202759l2.8994141,2.8994141c0.4780884,0.4786987,1.1271973,0.7471313,1.8037109,0.7460938c0.6766357,0.0001831,1.3256226-0.2686768,1.803894-0.7472534C22.2493286,20.2558594,22.2488403,18.6417236,21.2529297,17.6464844z M9.0084229,14.9970703c-3.3120728,0.0023193-5.9989624-2.6807861-6.0012817-5.9928589S5.6879272,3.005249,9,3.0029297c1.5910034-0.0026855,3.1175537,0.628479,4.2421875,1.7539062c1.1252441,1.1238403,1.7579956,2.6486206,1.7590942,4.2389526C15.0036011,12.3078613,12.3204956,14.994751,9.0084229,14.9970703z M20.5458984,20.5413818c-0.604126,0.6066284-1.5856934,0.6087036-2.1923828,0.0045166l-2.8994141-2.8994141c-0.2913818-0.2910156-0.4549561-0.6861572-0.4544678-1.0979614C15.0006714,15.6928101,15.6951294,15,16.5507812,15.0009766c0.4109497-0.0005493,0.8051758,0.1624756,1.0957031,0.453125l2.8994141,2.8994141C21.1482544,18.9584351,21.1482544,19.9364624,20.5458984,20.5413818z"/></svg>
									</a>
									<div class="dropdown-menu header-search dropdown-menu-start">
										<div class="input-group w-100 p-2">
											<input type="text" class="form-control" placeholder="Search....">
											<div class="input-group-text btn btn-primary">
												<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path  d="M21.2529297,17.6464844l-2.8994141-2.8994141c-0.0021973-0.0021973-0.0043945-0.0043945-0.0065918-0.0065918c-0.8752441-0.8721313-2.2249146-0.9760132-3.2143555-0.3148804l-0.8467407-0.8467407c1.0981445-1.2668457,1.7143555-2.887146,1.715332-4.5747681c0.0021973-3.8643799-3.1286621-6.9989014-6.993042-7.0011597S2.0092773,5.1315308,2.007019,8.9959106S5.1356201,15.994812,9,15.9970703c1.6889038,0.0029907,3.3114014-0.6120605,4.5789185-1.7111206l0.84729,0.84729c-0.6630859,0.9924316-0.5566406,2.3459473,0.3208618,3.2202759l2.8994141,2.8994141c0.4780884,0.4786987,1.1271973,0.7471313,1.8037109,0.7460938c0.6766357,0.0001831,1.3256226-0.2686768,1.803894-0.7472534C22.2493286,20.2558594,22.2488403,18.6417236,21.2529297,17.6464844z M9.0084229,14.9970703c-3.3120728,0.0023193-5.9989624-2.6807861-6.0012817-5.9928589S5.6879272,3.005249,9,3.0029297c1.5910034-0.0026855,3.1175537,0.628479,4.2421875,1.7539062c1.1252441,1.1238403,1.7579956,2.6486206,1.7590942,4.2389526C15.0036011,12.3078613,12.3204956,14.994751,9.0084229,14.9970703z M20.5458984,20.5413818c-0.604126,0.6066284-1.5856934,0.6087036-2.1923828,0.0045166l-2.8994141-2.8994141c-0.2913818-0.2910156-0.4549561-0.6861572-0.4544678-1.0979614C15.0006714,15.6928101,15.6951294,15,16.5507812,15.0009766c0.4109497-0.0005493,0.8051758,0.1624756,1.0957031,0.453125l2.8994141,2.8994141C21.1482544,18.9584351,21.1482544,19.9364624,20.5458984,20.5413818z"/></svg>
											</div>
										</div>
									</div>
								</div>
								<!-- SEARCH -->
								<button class="navbar-toggler navresponsive-toggler d-md-none ms-auto" type="button"
									data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4"
									aria-controls="navbarSupportedContent-4" aria-expanded="false"
									aria-label="Toggle navigation">
									<span class="navbar-toggler-icon fe fe-more-vertical"></span>
								</button>
								<div class="navbar navbar-collapse responsive-navbar p-0">
									<div class="collapse navbar-collapse" id="navbarSupportedContent-4">
										<div class="d-flex order-lg-2">
											<div class="dropdown d-md-none d-flex">
												<a href="#" class="nav-link icon" data-bs-toggle="dropdown">
													<svg xmlns="http://www.w3.org/2000/svg" class="header-icon" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path  d="M21.2529297,17.6464844l-2.8994141-2.8994141c-0.0021973-0.0021973-0.0043945-0.0043945-0.0065918-0.0065918c-0.8752441-0.8721313-2.2249146-0.9760132-3.2143555-0.3148804l-0.8467407-0.8467407c1.0981445-1.2668457,1.7143555-2.887146,1.715332-4.5747681c0.0021973-3.8643799-3.1286621-6.9989014-6.993042-7.0011597S2.0092773,5.1315308,2.007019,8.9959106S5.1356201,15.994812,9,15.9970703c1.6889038,0.0029907,3.3114014-0.6120605,4.5789185-1.7111206l0.84729,0.84729c-0.6630859,0.9924316-0.5566406,2.3459473,0.3208618,3.2202759l2.8994141,2.8994141c0.4780884,0.4786987,1.1271973,0.7471313,1.8037109,0.7460938c0.6766357,0.0001831,1.3256226-0.2686768,1.803894-0.7472534C22.2493286,20.2558594,22.2488403,18.6417236,21.2529297,17.6464844z M9.0084229,14.9970703c-3.3120728,0.0023193-5.9989624-2.6807861-6.0012817-5.9928589S5.6879272,3.005249,9,3.0029297c1.5910034-0.0026855,3.1175537,0.628479,4.2421875,1.7539062c1.1252441,1.1238403,1.7579956,2.6486206,1.7590942,4.2389526C15.0036011,12.3078613,12.3204956,14.994751,9.0084229,14.9970703z M20.5458984,20.5413818c-0.604126,0.6066284-1.5856934,0.6087036-2.1923828,0.0045166l-2.8994141-2.8994141c-0.2913818-0.2910156-0.4549561-0.6861572-0.4544678-1.0979614C15.0006714,15.6928101,15.6951294,15,16.5507812,15.0009766c0.4109497-0.0005493,0.8051758,0.1624756,1.0957031,0.453125l2.8994141,2.8994141C21.1482544,18.9584351,21.1482544,19.9364624,20.5458984,20.5413818z"/></svg>
												</a>
												<div class="dropdown-menu header-search dropdown-menu-start">
													<div class="input-group w-100 p-2">
														<input type="text" class="form-control" placeholder="Search....">
														<div class="input-group-text btn btn-primary">
															<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path  d="M21.2529297,17.6464844l-2.8994141-2.8994141c-0.0021973-0.0021973-0.0043945-0.0043945-0.0065918-0.0065918c-0.8752441-0.8721313-2.2249146-0.9760132-3.2143555-0.3148804l-0.8467407-0.8467407c1.0981445-1.2668457,1.7143555-2.887146,1.715332-4.5747681c0.0021973-3.8643799-3.1286621-6.9989014-6.993042-7.0011597S2.0092773,5.1315308,2.007019,8.9959106S5.1356201,15.994812,9,15.9970703c1.6889038,0.0029907,3.3114014-0.6120605,4.5789185-1.7111206l0.84729,0.84729c-0.6630859,0.9924316-0.5566406,2.3459473,0.3208618,3.2202759l2.8994141,2.8994141c0.4780884,0.4786987,1.1271973,0.7471313,1.8037109,0.7460938c0.6766357,0.0001831,1.3256226-0.2686768,1.803894-0.7472534C22.2493286,20.2558594,22.2488403,18.6417236,21.2529297,17.6464844z M9.0084229,14.9970703c-3.3120728,0.0023193-5.9989624-2.6807861-6.0012817-5.9928589S5.6879272,3.005249,9,3.0029297c1.5910034-0.0026855,3.1175537,0.628479,4.2421875,1.7539062c1.1252441,1.1238403,1.7579956,2.6486206,1.7590942,4.2389526C15.0036011,12.3078613,12.3204956,14.994751,9.0084229,14.9970703z M20.5458984,20.5413818c-0.604126,0.6066284-1.5856934,0.6087036-2.1923828,0.0045166l-2.8994141-2.8994141c-0.2913818-0.2910156-0.4549561-0.6861572-0.4544678-1.0979614C15.0006714,15.6928101,15.6951294,15,16.5507812,15.0009766c0.4109497-0.0005493,0.8051758,0.1624756,1.0957031,0.453125l2.8994141,2.8994141C21.1482544,18.9584351,21.1482544,19.9364624,20.5458984,20.5413818z"/></svg>
														</div>
													</div>
												</div>
											</div>
											<!-- SEARCH -->
											<div class="dropdown  d-flex">
												<a class="nav-link icon theme-layout nav-link-bg layout-setting">
													<span class="dark-layout">
														<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M22.0482178,13.2746582c-0.1265259-0.2453003-0.4279175-0.3416138-0.6732178-0.2150879C20.1774902,13.6793823,18.8483887,14.0019531,17.5,14c-0.8480835-0.0005493-1.6913452-0.1279297-2.50177-0.3779297c-4.4887085-1.3847046-7.0050049-6.1460571-5.6203003-10.6347656c0.0320435-0.1033325,0.0296021-0.2142944-0.0068359-0.3161621C9.2781372,2.411377,8.9921875,2.2761841,8.7324219,2.3691406C4.6903076,3.800293,1.9915771,7.626709,2,11.9146729C2.0109863,17.4956055,6.5440674,22.0109863,12.125,22c4.9342651,0.0131226,9.1534424-3.5461426,9.9716797-8.4121094C22.1149292,13.4810181,22.0979614,13.3710327,22.0482178,13.2746582z M16.0877075,20.0958252c-4.5321045,2.1853027-9.9776611,0.2828979-12.1630249-4.2492065S3.6417236,5.8689575,8.1738281,3.6835938C8.0586548,4.2776489,8.0004272,4.8814087,8,5.4865723C7.9962769,10.7369385,12.2495728,14.9962769,17.5,15c1.1619263,0.0023193,2.3140869-0.2119751,3.3974609-0.6318359C20.1879272,16.8778076,18.4368896,18.9630127,16.0877075,20.0958252z"/></svg>
													</span>
													<span class="light-layout">
														<svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M6.3427734,16.9501953l-1.4140625,1.4140625c-0.09375,0.09375-0.1463623,0.2208862-0.1464233,0.3534546c0,0.276123,0.2238159,0.5,0.499939,0.500061c0.1326294,0.0001831,0.2598877-0.0525513,0.3535156-0.1464844l1.4140015-1.4140625c0.0024414-0.0023804,0.0047607-0.0047607,0.0071411-0.0071411c0.1932373-0.1971436,0.1900635-0.5137329-0.0071411-0.7069702C6.8526001,16.7498169,6.5360718,16.7529907,6.3427734,16.9501953z M6.3427734,7.0498047c0.0936279,0.0939331,0.2208862,0.1466675,0.3535156,0.1464844c0.1325684,0,0.2597046-0.0526733,0.3534546-0.1464233c0.1952515-0.1952515,0.1953125-0.5118408,0.000061-0.7070923L5.6356812,4.9287109c-0.1943359-0.1904907-0.5054321-0.1904907-0.6998291,0C4.7386475,5.1220093,4.7354736,5.4385376,4.9287109,5.6357422L6.3427734,7.0498047z M12,5h0.0006104C12.2765503,4.9998169,12.5001831,4.776001,12.5,4.5v-2C12.5,2.223877,12.276123,2,12,2s-0.5,0.223877-0.5,0.5v2.0006104C11.5001831,4.7765503,11.723999,5.0001831,12,5z M17.3037109,7.1962891c0.1326294,0.0001831,0.2598877-0.0525513,0.3535156-0.1464844l1.4140625-1.4141235c0.0023804-0.0023193,0.0047607-0.0046997,0.0070801-0.0070801c0.1932983-0.1972046,0.1900635-0.5137329-0.0070801-0.7070312c-0.1972046-0.1932373-0.5137329-0.1900635-0.7070312,0.0071411l-1.4140625,1.4140625c-0.09375,0.09375-0.1463623,0.2208862-0.1464233,0.3534546C16.803772,6.9723511,17.0275879,7.196228,17.3037109,7.1962891z M5,12c0-0.276123-0.223877-0.5-0.5-0.5h-2C2.223877,11.5,2,11.723877,2,12s0.223877,0.5,0.5,0.5h2C4.776123,12.5,5,12.276123,5,12z M17.6572266,16.9502563c-0.0023804-0.0023804-0.0046997-0.0047607-0.0070801-0.0070801c-0.1972046-0.1932983-0.5137329-0.1901245-0.7070312,0.0070801c-0.1932373,0.1971436-0.1901245,0.5136719,0.0070801,0.7069702l1.4140625,1.4140625c0.0936279,0.0939331,0.2208252,0.1466675,0.3534546,0.1464844c0.1325684,0,0.2597046-0.0526733,0.3534546-0.1463623c0.1953125-0.1952515,0.1953125-0.5118408,0.0001221-0.7070923L17.6572266,16.9502563z M12,19c-0.276123,0-0.5,0.223877-0.5,0.5v2.0005493C11.5001831,21.7765503,11.723999,22.0001831,12,22h0.0006104c0.2759399-0.0001831,0.4995728-0.223999,0.4993896-0.5v-2C12.5,19.223877,12.276123,19,12,19z M21.5,11.5h-2c-0.276123,0-0.5,0.223877-0.5,0.5s0.223877,0.5,0.5,0.5h2c0.276123,0,0.5-0.223877,0.5-0.5S21.776123,11.5,21.5,11.5z M12,6.5c-3.0375366,0-5.5,2.4624634-5.5,5.5s2.4624634,5.5,5.5,5.5c3.0360107-0.0037842,5.4962158-2.4639893,5.5-5.5C17.5,8.9624634,15.0375366,6.5,12,6.5z M12,16.5c-2.4852905,0-4.5-2.0147095-4.5-4.5S9.5147095,7.5,12,7.5c2.4841309,0.0026855,4.4973145,2.0158691,4.5,4.5C16.5,14.4852905,14.4852905,16.5,12,16.5z"/></svg>
													</span>
												</a>
											</div>
											<div class="dropdown d-md-flex">
												<a class="nav-link icon full-screen-link nav-link-bg">
													<svg xmlns="http://www.w3.org/2000/svg"  enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M8.5,21H3v-5.5C3,15.223877,2.776123,15,2.5,15S2,15.223877,2,15.5v6.0005493C2.0001831,21.7765503,2.223999,22.0001831,2.5,22h6C8.776123,22,9,21.776123,9,21.5S8.776123,21,8.5,21z M8.5,2H2.4993896C2.2234497,2.0001831,1.9998169,2.223999,2,2.5v6.0005493C2.0001831,8.7765503,2.223999,9.0001831,2.5,9h0.0006104C2.7765503,8.9998169,3.0001831,8.776001,3,8.5V3h5.5C8.776123,3,9,2.776123,9,2.5S8.776123,2,8.5,2z M21.5,15c-0.276123,0-0.5,0.223877-0.5,0.5V21h-5.5c-0.276123,0-0.5,0.223877-0.5,0.5s0.223877,0.5,0.5,0.5h6.0006104C21.7765503,21.9998169,22.0001831,21.776001,22,21.5v-6C22,15.223877,21.776123,15,21.5,15z M21.5,2h-6C15.223877,2,15,2.223877,15,2.5S15.223877,3,15.5,3H21v5.5005493C21.0001831,8.7765503,21.223999,9.0001831,21.5,9h0.0006104C21.7765503,8.9998169,22.0001831,8.776001,22,8.5V2.4993896C21.9998169,2.2234497,21.776001,1.9998169,21.5,2z"/></svg>
												</a>
											</div>
											<!-- Profile -->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /app-Header -->

				<!--APP-SIDEBAR-->
				<div class="sticky">
					<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
					<div class="app-sidebar">
						<div class="side-header">
							<a class="header-brand1 d-flex" href="{{ url('/dashboard') }}">
                                <img src="{{ asset('smooth/images/logo-single.png') }}" style="background-color: white;" alt="">
							</a><!-- LOGO -->
						</div>
						<div class="main-sidemenu">
							<div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg"
									fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
									<path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
								</svg>
							</div>
                            <ul class="side-menu">
                                <li class="slide">
									<a href="/dashboard-reseller" class="side-menu__item has-link {{ Request::is('dashboard')?'active':'' }}" data-bs-toggle="slide" href="index.html">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M19.9794922,7.9521484l-6-5.2666016c-1.1339111-0.9902344-2.8250732-0.9902344-3.9589844,0l-6,5.2666016C3.3717041,8.5219116,2.9998169,9.3435669,3,10.2069702V19c0.0018311,1.6561279,1.3438721,2.9981689,3,3h2.5h7c0.0001831,0,0.0003662,0,0.0006104,0H18c1.6561279-0.0018311,2.9981689-1.3438721,3-3v-8.7930298C21.0001831,9.3435669,20.6282959,8.5219116,19.9794922,7.9521484z M15,21H9v-6c0.0014038-1.1040039,0.8959961-1.9985962,2-2h2c1.1040039,0.0014038,1.9985962,0.8959961,2,2V21z M20,19c-0.0014038,1.1040039-0.8959961,1.9985962-2,2h-2v-6c-0.0018311-1.6561279-1.3438721-2.9981689-3-3h-2c-1.6561279,0.0018311-2.9981689,1.3438721-3,3v6H6c-1.1040039-0.0014038-1.9985962-0.8959961-2-2v-8.7930298C3.9997559,9.6313477,4.2478027,9.0836182,4.6806641,8.7041016l6-5.2666016C11.0455933,3.1174927,11.5146484,2.9414673,12,2.9423828c0.4853516-0.0009155,0.9544067,0.1751099,1.3193359,0.4951172l6,5.2665405C19.7521973,9.0835571,20.0002441,9.6313477,20,10.2069702V19z"/></svg>
                                        <span class="side-menu__label">Dashboard</span>
									</a>
								</li>
                            </ul>
                            <ul class="side-menu">
                                <li class="slide">
									<a href="/transaction-reseller" class="side-menu__item has-link {{ Request::is('dashboard')?'active':'' }}" data-bs-toggle="slide" href="index.html">
										<svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                                            <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                                            <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                                            <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                                          </svg>
                                        <span class="side-menu__label">Transaction</span>
									</a>
								</li>
                            </ul>
                            <ul class="side-menu">
                                <li class="slide">
									<a href="/transaction-dropshipper" class="side-menu__item has-link {{ Request::is('dashboard')?'active':'' }}" data-bs-toggle="slide" href="index.html">
										<svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" width="16" height="16" fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                                            <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.596 5 8 5.961 14.154 3.5zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                                          </svg>
                                        <span class="side-menu__label">Dropship</span>
									</a>
								</li>
                            </ul>
							<ul class="side-menu">
                                <li class="slide">
									<a href="/commission-reseller" class="side-menu__item has-link {{ Request::is('banner')?'active':'' }}" data-bs-toggle="slide">
                                        <ion-icon name="cart-outline" class="side-menu__icon" ></ion-icon>
										<span class="side-menu__label">Commission</span>
									</a>
								</li>
                                {{-- <li class="slide">
									<a href="/banner" class="side-menu__item has-link {{ Request::is('banner')?'active':'' }}" data-bs-toggle="slide">
                                        <ion-icon name="cart-outline" class="side-menu__icon" ></ion-icon>
										<span class="side-menu__label">Social Media</span>
									</a>
								</li>
                                <li class="slide">
									<a href="/videos" class="side-menu__item has-link {{ Request::is('videos')?'active':'' }}" data-bs-toggle="slide">
                                        <ion-icon name="cart-outline" class="side-menu__icon" ></ion-icon>
										<span class="side-menu__label">Video</span>
									</a>
								</li> --}}
                                <li class="slide">
                                    <form method="POST" action="{{ route('logout') }}" class="side-menu__item has-link">
                                        @csrf
                                        <x-responsive-nav-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();" side-menu__icon>
                                            {{ __('Log Out') }}
                                        </x-responsive-nav-link>
                                    </form>
								</li>
							</ul>
							<div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191"
									width="24" height="24" viewBox="0 0 24 24">
									<path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
								</svg>
							</div>
						</div>
					</div>
				</div>
				<!--/APP-SIDEBAR-->
                <!--app-content open-->
    <div class="app-content main-content mt-0">
    <div class="side-app">
        <!-- CONTAINER -->
        <div class="main-container container-fluid p-4">
         @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
                @yield('content')
            </div>
    </div>
    </div>
            </div>
			<!-- Country-selector modal-->
			<div class="modal fade" id="country-selector">
				<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content country-select-modal">
						<div class="modal-header">
							<h6 class="modal-title">Choose Country</h6><button aria-label="Close" class="btn-close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
						</div>
						<div class="modal-body">
							<ul class="row row-sm p-3">
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block active">
										<span class="country-selector"><img alt="unitedstates" src="../asset_admin/images/flags/us_flag.jpg" class="me-2 language"></span>United States
									</a>
								</li>
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block">
										<span class="country-selector"><img alt="italy" src="../asset_admin/images/flags/italy_flag.jpg" class="me-2 language"></span>Italy
									</a>
								</li>
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block">
										<span class="country-selector"><img alt="spain" src="../asset_admin/images/flags/spain_flag.jpg" class="me-2 language"></span>Spain
									</a>
								</li>
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block">
										<span class="country-selector"><img alt="india" src="../asset_admin/images/flags/india_flag.jpg" class="me-2 language"></span>India
								</a>
								</li>
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block">
										<span class="country-selector"><img alt="french" src="../asset_admin/images/flags/french_flag.jpg" class="me-2 language"></span>French
									</a>
								</li>
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block">
										<span class="country-selector"><img alt="russia" src="../asset_admin/images/flags/russia_flag.jpg" class="me-2 language"></span>Russia
									</a>
								</li>
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block">
										<span class="country-selector"><img alt="germany" src="../asset_admin/images/flags/germany_flag.jpg" class="me-2 language"></span>Germany
									</a>
								</li>
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block">
										<span class="country-selector"><img alt="argentina" src="../asset_admin/images/flags/argentina_flag.jpg" class="me-2 language"></span>Argentina
									</a>
								</li>
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block">
										<span class="country-selector"><img alt="uae" src="../asset_admin/images/flags/uae_flag.jpg" class="me-2 language"></span>UAE
									</a>
								</li>
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block">
										<span class="country-selector"><img alt="austria" src="../asset_admin/images/flags/austria_flag.jpg" class="me-2 language"></span>Austria
									</a>
								</li>
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block">
										<span class="country-selector"><img alt="mexico" src="../asset_admin/images/flags/mexico_flag.jpg" class="me-2 language"></span>Mexico
									</a>
								</li>
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block">
										<span class="country-selector"><img alt="china" src="../asset_admin/images/flags/china_flag.jpg" class="me-2 language"></span>China
								</a>
								</li>
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block">
										<span class="country-selector"><img alt="poland" src="../asset_admin/images/flags/poland_flag.jpg" class="me-2 language"></span>Poland
									</a>
								</li>
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block">
										<span class="country-selector"><img alt="canada" src="../asset_admin/images/flags/canada_flag.jpg" class="me-2 language"></span>Canada
									</a>
								</li>
								<li class="col-lg-4 mb-2">
									<a class="btn btn-country btn-lg btn-block">
										<span class="country-selector"><img alt="malaysia" src="../asset_admin/images/flags/malaysia_flag.jpg" class="me-2 language"></span>Malaysia
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- /Country-selector modal-->

			<!-- FOOTER -->
			<footer class="footer">
				<div class="container">
					<div class="row align-items-center flex-row-reverse">
						<div class="col-md-12 col-sm-12 text-center">
							 {{-- Copyright © 2022 <a href="#">Noa</a>. Designed with <span class="fa fa-heart text-danger"></span> by <a href="#"> Spruko </a> All rights reserved --}}
						</div>
					</div>
				</div>
			</footer>
			<!-- FOOTER CLOSED -->
		</div>

		<!-- BACK-TO-TOP -->
		<a href="#top" id="back-to-top"><i class="fa fa-long-arrow-up"></i></a>

		<!-- JQUERY JS -->
		<script src="{{ asset('asset_admin/js/jquery.min.js') }}"></script>

		<!-- BOOTSTRAP JS -->
		<script src="{{ asset('asset_admin/plugins/bootstrap/js/popper.min.js') }}"></script>
		<script src="{{ asset('asset_admin/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

        <!-- SIDE-MENU JS -->
		<script src="{{ asset('asset_admin/plugins/sidemenu/sidemenu.js') }}"></script>

		<!-- INTERNAL SELECT2 JS -->
		<script src="{{ asset('asset_admin/plugins/select2/select2.full.min.js') }}"></script>

		<!-- DATA TABLE JS-->
		<script src="{{ asset('asset_admin/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('asset_admin/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
		<script src="{{ asset('asset_admin/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
		<script src="{{ asset('asset_admin/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
		<script src="{{ asset('asset_admin/plugins/datatable/js/jszip.min.js') }}"></script>
		<script src="{{ asset('asset_admin/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
		<script src="{{ asset('asset_admin/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
		<script src="{{ asset('asset_admin/plugins/datatable/js/buttons.html5.min.js') }}"></script>
		<script src="{{ asset('asset_admin/plugins/datatable/js/buttons.print.min.js') }}"></script>
		<script src="{{ asset('asset_admin/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
		<script src="{{ asset('asset_admin/plugins/datatable/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('asset_admin/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
		<script src="{{ asset('asset_admin/js/table-data.js') }}"></script>

		<!-- Perfect SCROLLBAR JS-->
		<script src="{{ asset('asset_admin/plugins/p-scroll/perfect-scrollbar.js') }}"></script>
		<script src="{{ asset('asset_admin/plugins/p-scroll/pscroll.js') }}"></script>

		<!-- STICKY JS -->
		<script src="{{ asset('asset_admin/js/sticky.js') }}"></script>

		<!-- COLOR THEME JS -->
		<script src="{{ asset('asset_admin/js/themeColors.js') }}"></script>

		<!-- CUSTOM JS -->
		<script src="{{ asset('asset_admin/js/custom.js') }}"></script>
        		<!-- WYSIWYG Editor JS -->
		<script src="{{ asset('asset_admin/plugins/wysiwyag/jquery.richtext.js') }}"></script>
		<script src="{{ asset('asset_admin/plugins/wysiwyag/wysiwyag.js') }}"></script>
        <!-- FORM WIZARD JS-->
        <script src="{{ asset('asset_admin/plugins/formwizard/jquery.smartWizard.js') }}"></script>
        <script src="{{ asset('asset_admin/plugins/formwizard/fromwizard.js') }}"></script>
        <script src="{{ asset('asset_admin/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
        <script src="{{ asset('asset_admin/plugins/parsleyjs/parsley.min.js') }}"></script>
        <!-- INTERNAL ACCORDION-WIZARD-FORM JS-->
        <script src="{{ asset('asset_admin/plugins/accordion-Wizard-Form/jquery.accordion-wizard.min.js') }}"></script>
        <script src="{{ asset('asset_admin/js/form-wizard.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script>
            $(document).ready(function () {
                $('#logoutForm').on('submit', function (e) {
                    e.preventDefault(); // Menghentikan pengiriman form

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You will log out now!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Logout!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika pengguna mengonfirmasi, kirimkan form
                            $('#logoutForm').off('submit'); // Matikan event handler agar tidak ada konfirmasi tambahan
                            $('#logoutForm').submit(); // Kirim form logout setelah konfirmasi
                        }
                    });
                });
            });
        </script>
        <script>
            function showTab(tabId) {
                // Hide all tabs
                document.querySelectorAll('.tab-content').forEach(tab => {
                    tab.style.display = 'none';
                });

                // Show the selected tab
                document.getElementById(tabId + '_tab').style.display = 'block';
            }
        </script>
    </body>
</html>
