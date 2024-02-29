<aside class="left-sidebar" data-sidebarbg="skin5">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
                <li class="sidebar-item <?php if(current_url() == url_to('dashboard')) echo "selected"; ?>">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= url_to('dashboard') ?>" aria-expanded="false">
                        <i class="fas fa-fire"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <?php foreach (menu() as $parent) { ?>
                <li class="sidebar-item <?= current_url() == base_url($parent->route) . '/' || in_array(uri_string(), array_column($parent->children, 'route')) ? 'selected' : '' ?>">
                    <a href="<?= base_url($parent->route) ?>" class="sidebar-link waves-effect waves-dark <?= current_url() == base_url($parent->route) || in_array(uri_string(), array_column($parent->children, 'route')) ? 'active' : '' ?>
                        <?php if (count($parent->children)) { ?> has-arrow <?php } ?>">
                        <i class="<?= $parent->icon ?>"></i>
                        <span class="hide-menu"><?= $parent->title ?></span> 
                    </a>
                    <?php if (count($parent->children)) { ?>
                    <ul class="collapse first-level">
                        <?php foreach ($parent->children as $child) { ?>
                        <li class="sidebar-item">
                            <a href="<?= base_url($child->route) ?>"
                                class="sidebar-link <?= current_url() == base_url($child->route) ? 'active' : '' ?>">
                                <i class="<?= $child->icon ?>"></i>
                                <span class="hide-menu"><?= $child->title ?></span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                    <?php } ?>
                </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</aside>