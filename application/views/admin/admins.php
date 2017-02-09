<main>
    <header>
        <h2>Admins&nbsp;<?="<span style='color:lightgreen;font-weight:bold;font-size:0.7em;'>".$this->session->message."<span>"; ?></h2>
        <a href="<?= base_url('admin/add_admin'); ?>"><button type="button" id="add_product_button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add a new admin</button></a>
    </header>
    <section class="admins">
        <table id="admins_table" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="first-row headerSortDown header">NAME</th>
                    <th class="header">RANK</th>
                </tr>
            </thead>
            <tbody>
               <?php foreach($admins as $admin) {?>
               <tr>
                <td> 
                    <a target="_blank" href="<?=base_url('admin/admin_details/'.$admin->id); ?>">
                        <?= $admin->name;?> 
                    </a>
                </td>
                <td><span class="glyphicon glyphicon-<?php echo $admin->super_admin? 'king' : 'pawn' ?>"></span></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</section>
</main>