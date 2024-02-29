<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title"><?= $breadcrumb['title'] ?></h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <?php foreach ($breadcrumb['page'] as $page) : ?>
                            <li class="breadcrumb-item
                            <?php if ($page['active']) : ?>
                                active
                            <?php endif ?>
                            " aria-current="page">
                                <?php if ($page['active']) : ?>
                                    <?= $page['title'] ?>
                                <?php else : ?>
                                    <a href="<?= url_to($page['url_to']) ?>"><?= $page['title'] ?></a>
                                <?php endif ?>
                            </li>
                        <?php endforeach ?>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>