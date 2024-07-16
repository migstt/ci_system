<div class="sidebar">
    <div class="logo-details">
        <i class='bx bxl-c-plus-plus' style="overflow-y: hidden;"></i>
        <span class="logo_name">Cilog</span>
    </div>
    <div class="user-profile">
        <div class="user-initials">
            <?php
            $initials = strtoupper($current_user_first_name[0] . $current_user_last_name[0]);
            echo $initials;
            ?>
        </div>
        <div class="user-info">
            <span class="user_name"><?php echo $current_user_full_name ?></span>
            <span class="user_role"><?php echo $current_user_type ?></span>
        </div>
    </div>
    <div class="nav-container">
        <ul class="nav-links">
            <li>
                <a href="#">
                    <i class='bx bx-grid-alt'></i>
                    <span class="link_name">Dashboard</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Dashboard</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="<?php echo site_url('contacts'); ?>">
                        <i class='bx bx-group'></i>
                        <span class="link_name">Contacts</span>
                    </a>
                </div>
                <ul class="sub-menu">
                    <li><a class="link_name" href="<?php echo site_url('contacts'); ?>">Contacts</a></li>
                </ul>
            </li>
            <li>
                <div class="iocn-link">
                    <a href="<?php echo site_url('tasks'); ?>">
                        <i class='bx bx-task'></i>
                        <span class="link_name">Tasks</span>
                    </a>
                    <i class='bx bxs-chevron-down arrow'></i>
                </div>
                <ul class="sub-menu mt-1">
                    <li><a class="link_name" href="<?php echo site_url('tasks'); ?>">Tasks</a></li>
                    <li><a href="#">Pending</a></li>
                    <li><a href="#">In Progess</a></li>
                    <li><a href="#">Completed</a></li>
                </ul>
            </li>
            <?php if ($current_user_type == 'Admin') : ?>
                <li>
                    <div class="iocn-link">
                        <a href="<?php echo site_url('inventory'); ?>">
                            <i class='bx bx-package'></i>
                            <span class="link_name">Inventory</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu mt-1">
                        <li><a class="link_name" href="<?php echo site_url('inventory'); ?>">Inventory</a></li>
                        <li><a href="<?php echo site_url('inventory'); ?>">Dashboard</a></li>
                        <li><a href="<?php echo site_url('inventory/all-items'); ?>">Inventory</a></li>
                        <li><a href="<?php echo site_url('inventory/stocks'); ?>">Stocks</a></li>
                        <li><a href="<?php echo site_url('inventory/location'); ?>">Location</a></li>
                        <li><a href="<?php echo site_url('inventory/category'); ?>">Category</a></li>
                        <li><a href="<?php echo site_url('inventory/suppliers'); ?>">Suppliers</a></li>
                        <li><a href="<?php echo site_url('inventory/items'); ?>">Items</a></li>
                        <li><a href="<?php echo site_url('inventory/reports'); ?>">Report Log</a></li>
                        <li><a href="<?php echo site_url('inventory/users'); ?>">Users</a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <li>
                <a href="<?php echo site_url('inventory/report'); ?>">
                    <i class='bx bx-file'></i>
                    <span class="link_name">Report Item</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('user/logout'); ?>">
                    <i class='bx bx-log-out'></i>
                    <span class="link_name">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>