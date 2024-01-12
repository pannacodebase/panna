<nav id="navbar" class="navbar">
    <ul>
        <li>
            <a class="nav-link scrollto" href="#">
                <img src="<?= $userPhoto ?>" width="30px" alt="User Photo" class="user-photo"> &nbsp;
                <span class="user-name" style="font-weight: bold;">
                    <?= $userName ?>
                </span>
            </a>
        </li>
        <li class="dropdown">
            <a href="#"><span>Settings</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
                <li><a href="?q=user-info">User Info</a></li>
                <li><a href="/chat">Chat</a></li>
                <li class="dropdown">
                    <a href="#"><span>Admin</span> <i class="bi bi-chevron-right"></i></a>
                    <ul>
                        <li><a href="?q=admin-users">Users</a></li>
                        <li><a href="/admin/ads">Ads</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#"><span>Brain</span> <i class="bi bi-chevron-right"></i></a>
                    <ul>
                        <li><a href="/brain/configure">Configure</a></li>
                        <li><a href="/brain/usage">Usage</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#"><span>Setup</span> <i class="bi bi-chevron-right"></i></a>
                    <ul>
                    <li><a href="?q=api-keys">API Keys</a></li>
                    <li><a href="/setup/configure">Configure</a></li>
                        <li><a href="/setup/model-parameters">Model Parameters</a></li>
                        <li><a href="/setup/template">Template</a></li>
                        <li><a href="?q=setup-data">Data</a></li>
                        <li><a href="/setup/moderation">Moderation</a></li>
                        <li><a href="/setup/maintenance">Maintenance</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
    <a class="nav-link scrollto" href="#">
        <?php
        if (isset($_SESSION['userRole'])) {
            $userRole = $_SESSION['userRole'];

            switch ($userRole) {
                case 'user':
                    echo "Regular User";
                    break;
                case 'influencer':
                    echo "Influencer";
                    break;
                case 'admin':
                    echo "Admin";
                    break;
                default:
                    echo "Welcome!";
            }
        } else {
            // Handle the case when user role is not set in the session
            echo "Welcome!";
        }
        ?>
    </a>
</li>

        <li style="text-align: left;"><a class="getstarted scrollto" href="<?= $logoutUrl ?>">Logout</a>

    </ul>
    <i class="bi bi-list mobile-nav-toggle"></i>
</nav><!-- .navbar -->