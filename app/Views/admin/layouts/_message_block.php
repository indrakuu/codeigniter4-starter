<?php if (session()->has('message')) : ?>
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<?= session('message') ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>
<?php if (session()->has('error')) : ?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<?= session('error') ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif ?>
<?php if (session()->has('errors')) : ?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<ul class="mb-0">
			<?php if (is_array(session('errors'))) : ?>
				<?php foreach (session('errors') as $error) : ?>
					<li><?= $error ?></li>
				<?php endforeach ?>
			<?php else : ?>
				<li><?= session('errors') ?></li>
			<?php endif ?>
		</ul>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
<?php endif ?>