<!-- Sidebar -->
<div class="sidebar sidebar-style-2">			
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <?php if(have_role(auth()->user->id,'pegawai')): ?>
                        <img src="<?=get_employee_pic(auth()->user->id)?>" alt="..." class="avatar-img rounded-circle">
                    <?php else: ?>
                        <img src="assets/img/user-placeholder.png" alt="..." class="avatar-img rounded-circle">
                    <?php endif ?>
                </div>
                <div class="info">
                    <a href="">
                        <span>
                            <?=auth()->user->name?>
                            <span class="user-level" style="text-transform:capitalize;"><?=get_role(auth()->user->id)->name?></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <?= generated_menu(auth()->user->id) ?>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->