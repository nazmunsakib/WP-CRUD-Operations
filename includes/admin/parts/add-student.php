<div class="wrap">
    <div class="add-new-student-container">
        <h3><?php _e( 'New Student', 'database-crud-operations' ); ?></h3>
        <form action="" method="post">
    
            <label for="fname">Name</label>
            <input type="text" id="name" name="name" placeholder="Your Name...">

            <label for="lname">Email</label>
            <input type="email" id="email" name="email" placeholder="Your Email...">
        
            <?php wp_nonce_field( 'new-student' ); ?>
            <?php submit_button( __( 'Add Student', 'database-crud-operations' ), 'primary', 'submit_student' ); ?>
        </form>
    </div>
</div>