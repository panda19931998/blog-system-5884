<?php if ($breadcrumb_list): ?>
<!-- begin breadcrumb -->
<ol class="breadcrumb pull-right">
<?php foreach ($breadcrumb_list as $breadcrumb): ?>
<?php if (!$breadcrumb['url']): ?>
<li class="breadcrumb-item active"><?php echo $breadcrumb['title'] ?></li>
<?php else: ?>
<li class="breadcrumb-item"><a href="<?php echo h($breadcrumb['url']) ?>"><?php echo $breadcrumb['title'] ?></a></li>
<?php endif; ?>
<?php endforeach; ?>
</ol>
<!-- end breadcrumb -->
<?php endif; ?>
