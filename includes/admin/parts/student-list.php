
<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'Students', 'database-crud-operations' ); ?></h1>
    <a href="<?php echo admin_url( 'admin.php?page=add-new-student' ); ?>" class="page-title-action"><?php _e( 'Add New', 'database-crud-operations' ); ?></a>
    <hr class="wp-header-end">

    <?php if ( isset( $_GET['added'] ) ) : ?>
        <div class="notice notice-success">
            <p><?php _e( 'Student data has been added successfully!', 'database-crud-operations' ); ?></p>
        </div>
    <?php endif; ?>

    <?php if ( isset( $_GET['student-deleted'] ) && 'true' == $_GET['student-deleted'] ) : ?>
        <div class="notice notice-success">
            <p><?php _e( 'Student is deleted!', 'database-crud-operations' ); ?></p>
        </div>
    <?php endif; ?>

    <form action="" method="post">
        <?php
            $table = new DatabaseCrudOperations\Admin\Student_List();
            $table->prepare_items();
            $table->display();
        ?>
    </form>
</div>