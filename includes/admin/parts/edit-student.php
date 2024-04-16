<div class="wrap">
    <div class="add-new-student-container">
        <h3><?php _e( 'Edit Student', 'database-crud-operations' ); ?></h3>
        <?php if ( isset( $_GET['updated-student'] ) ) : ?>
            <div class="notice notice-success">
                <p><?php _e( 'Student data has been Updated successfully!', 'database-crud-operations' ); ?></p>
            </div>
        <?php endif; ?>
        <form action="" method="post">
    
            <label for="fname">Name</label>
            <input type="text" id="name" name="name" placeholder="Your Name..." value="<?php echo esc_attr( $student->name ); ?>">

            <label for="lname">Email</label>
            <input type="email" id="email" name="email" placeholder="Your Email..." value="<?php echo esc_attr( $student->email ); ?>">

            <input type="hidden" name="id" value="<?php echo esc_attr( $student->id ); ?>">

            <?php wp_nonce_field( 'new-student' ); ?>
            <?php submit_button( __( 'Update', 'database-crud-operations' ), 'primary', 'submit_student' ); ?>
        </form>
    </div>
</div>