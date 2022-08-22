<!DOCTYPE html>

<html <?php language_attributes(); ?> >

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?></title>
	<?php wp_head(); ?>
</head>

<body class="ghs_body">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php foreach (ghs_get_navigation('Nav Bar') as $navItem): ?>
                    <?php if(empty($navItem['submenu'])): ?>
                        <li class="nav-item ">
                            <a class="nav-link <?php if($navItem['url'] == ghs_get_current_url()): echo "active"; endif; ?>" aria-current="page" href="<?php echo $navItem['url'] ?>">
                                <?php echo $navItem['title'] ?>
                            </a>
                        </li>
                    <?php else: ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle"
                                   href="#" role="button"
                                   data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    <?php echo $navItem['title'] ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($navItem['submenu'] as $sub): ?>
                                    <li>
                                        <a class="dropdown-item"
                                           href="<?php echo $sub['url'] ?>">
                                            <?php echo $sub['title'] ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
            <ul class="nav justify-content-end">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Active</a>
                </li>
            </ul>
        </div>
    </div>
</nav>