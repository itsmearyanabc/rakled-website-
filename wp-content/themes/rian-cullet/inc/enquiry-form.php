<?php
/**
 * Enquiry form: rendering, validation, storage and notification.
 *
 * Submissions are stored as a private custom post type BEFORE the email
 * is attempted. Shared hosting mail delivery is unreliable, and a lost
 * B2B enquiry is a lost customer, so the database copy is the record of
 * truth and the email is a convenience layered on top of it.
 *
 * Spam handling is deliberately plugin-free: a honeypot field plus a
 * timestamp trap. Neither inconveniences a real visitor and neither
 * sends any visitor data to a third party.
 *
 * @package RianCullet
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

const RC_ENQUIRY_CPT    = 'rc_enquiry';
const RC_ENQUIRY_ACTION = 'rc_enquiry_submit';
const RC_MIN_FILL_TIME  = 3; // Seconds. Faster than this, assume a bot.

add_action( 'init', 'rc_register_enquiry_cpt' );
/**
 * Register the private post type that stores enquiries.
 */
function rc_register_enquiry_cpt(): void {
	register_post_type(
		RC_ENQUIRY_CPT,
		array(
			'labels'              => array(
				'name'          => __( 'Enquiries', 'rian-cullet' ),
				'singular_name' => __( 'Enquiry', 'rian-cullet' ),
				'menu_name'     => __( 'Enquiries', 'rian-cullet' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-email-alt',
			'capability_type'     => 'post',
			'capabilities'        => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'        => true,
			'supports'            => array( 'title', 'editor', 'custom-fields' ),
			'has_archive'         => false,
			'rewrite'             => false,
			'exclude_from_search' => true,
		)
	);
}

/**
 * The fields this form collects.
 *
 * @return array<string, array<string, mixed>>
 */
function rc_enquiry_fields(): array {
	return array(
		'name'        => array(
			'label'        => __( 'Name', 'rian-cullet' ),
			'type'         => 'text',
			'required'     => true,
			'autocomplete' => 'name',
		),
		'company'     => array(
			'label'        => __( 'Company', 'rian-cullet' ),
			'type'         => 'text',
			'required'     => false,
			'autocomplete' => 'organization',
		),
		'email'       => array(
			'label'        => __( 'Email', 'rian-cullet' ),
			'type'         => 'email',
			'required'     => true,
			'autocomplete' => 'email',
		),
		'phone'       => array(
			'label'        => __( 'Phone', 'rian-cullet' ),
			'type'         => 'tel',
			'required'     => false,
			'autocomplete' => 'tel',
		),
		'requirement' => array(
			'label'    => __( 'Material requirement', 'rian-cullet' ),
			'type'     => 'select',
			'required' => false,
			'options'  => array(
				''         => __( 'Select an option', 'rian-cullet' ),
				'factory'  => __( 'Factory cullet', 'rian-cullet' ),
				'foreign'  => __( 'Foreign / post-consumer cullet', 'rian-cullet' ),
				'flint'    => __( 'Flint (white) cullet', 'rian-cullet' ),
				'multiple' => __( 'More than one', 'rian-cullet' ),
				'other'    => __( 'Other / not sure yet', 'rian-cullet' ),
			),
		),
		'message'     => array(
			'label'    => __( 'Message', 'rian-cullet' ),
			'type'     => 'textarea',
			'required' => true,
		),
	);
}

/**
 * Render the enquiry form.
 */
function rc_enquiry_form(): void {

	$fields = rc_enquiry_fields();
	$state  = rc_enquiry_state();
	?>
	<div class="rc-contact__form">

		<?php if ( 'sent' === $state['status'] ) : ?>
			<p class="rc-notice" role="status">
				<?php esc_html_e( 'Thank you. Your enquiry has been received and our team will be in touch.', 'rian-cullet' ); ?>
			</p>
		<?php endif; ?>

		<?php if ( ! empty( $state['errors'] ) ) : ?>
			<div class="rc-notice rc-notice--error" role="alert">
				<strong><?php esc_html_e( 'Please check the following:', 'rian-cullet' ); ?></strong>
				<ul class="rc-notice__list">
					<?php foreach ( $state['errors'] as $rc_error ) : ?>
						<li><?php echo esc_html( $rc_error ); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<form
			class="rc-form"
			method="post"
			action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
			novalidate
		>
			<input type="hidden" name="action" value="<?php echo esc_attr( RC_ENQUIRY_ACTION ); ?>">
			<input type="hidden" name="rc_time" value="<?php echo esc_attr( (string) time() ); ?>">
			<input type="hidden" name="rc_redirect" value="<?php echo esc_url( rc_current_url() ); ?>">
			<?php wp_nonce_field( RC_ENQUIRY_ACTION, 'rc_nonce' ); ?>

			<p class="rc-hp" aria-hidden="true">
				<label for="rc-website"><?php esc_html_e( 'Leave this field empty', 'rian-cullet' ); ?></label>
				<input type="text" id="rc-website" name="rc_website" tabindex="-1" autocomplete="off">
			</p>

			<?php
			foreach ( $fields as $rc_key => $rc_field ) :
				$rc_id    = 'rc-field-' . $rc_key;
				$rc_value = $state['old'][ $rc_key ] ?? '';
				$rc_full  = in_array( $rc_field['type'], array( 'textarea', 'select' ), true );
				?>
				<div class="rc-field<?php echo $rc_full ? ' rc-field--full' : ''; ?>">

					<label class="rc-label" for="<?php echo esc_attr( $rc_id ); ?>">
						<?php echo esc_html( $rc_field['label'] ); ?>
						<?php if ( $rc_field['required'] ) : ?>
							<span class="rc-label__req" aria-hidden="true">*</span>
							<span class="rc-sr-only"><?php esc_html_e( 'required', 'rian-cullet' ); ?></span>
						<?php endif; ?>
					</label>

					<?php if ( 'textarea' === $rc_field['type'] ) : ?>
						<textarea class="rc-textarea" id="<?php echo esc_attr( $rc_id ); ?>" name="<?php echo esc_attr( $rc_key ); ?>" rows="6" <?php echo $rc_field['required'] ? 'required aria-required="true"' : ''; ?>><?php echo esc_textarea( $rc_value ); ?></textarea>

					<?php elseif ( 'select' === $rc_field['type'] ) : ?>
						<select class="rc-select" id="<?php echo esc_attr( $rc_id ); ?>" name="<?php echo esc_attr( $rc_key ); ?>">
							<?php foreach ( $rc_field['options'] as $rc_opt => $rc_opt_label ) : ?>
								<option value="<?php echo esc_attr( $rc_opt ); ?>" <?php selected( $rc_value, $rc_opt ); ?>><?php echo esc_html( $rc_opt_label ); ?></option>
							<?php endforeach; ?>
						</select>

					<?php else : ?>
						<input
							class="rc-input"
							type="<?php echo esc_attr( $rc_field['type'] ); ?>"
							id="<?php echo esc_attr( $rc_id ); ?>"
							name="<?php echo esc_attr( $rc_key ); ?>"
							value="<?php echo esc_attr( $rc_value ); ?>"
							autocomplete="<?php echo esc_attr( $rc_field['autocomplete'] ?? 'on' ); ?>"
							<?php echo $rc_field['required'] ? 'required aria-required="true"' : ''; ?>
						>
					<?php endif; ?>

				</div>
			<?php endforeach; ?>

			<div class="rc-contact__submit">
				<?php rc_button( array( 'label' => __( 'Submit enquiry', 'rian-cullet' ), 'type' => 'submit' ) ); ?>
			</div>
		</form>
	</div>
	<?php
}

/**
 * The URL to return the visitor to after submitting.
 *
 * @return string
 */
function rc_current_url(): string {
	$permalink = get_permalink();
	return $permalink ? $permalink : home_url( '/contact/' );
}

/**
 * Read the post-submission state handed back through the redirect.
 *
 * @return array<string, mixed>
 */
function rc_enquiry_state(): array {

	$state = array(
		'status' => '',
		'errors' => array(),
		'old'    => array(),
	);

	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	$status = isset( $_GET['enquiry'] ) ? sanitize_key( wp_unslash( $_GET['enquiry'] ) ) : '';
	$token  = isset( $_GET['rc_t'] ) ? sanitize_key( wp_unslash( $_GET['rc_t'] ) ) : '';
	// phpcs:enable

	if ( 'sent' === $status ) {
		$state['status'] = 'sent';
		return $state;
	}

	if ( 'error' === $status && $token ) {
		$stored = get_transient( 'rc_enq_' . $token );

		if ( is_array( $stored ) ) {
			$state['status'] = 'error';
			$state['errors'] = $stored['errors'] ?? array();
			$state['old']    = $stored['old'] ?? array();
			delete_transient( 'rc_enq_' . $token );
		}
	}

	return $state;
}

add_action( 'admin_post_' . RC_ENQUIRY_ACTION, 'rc_handle_enquiry' );
add_action( 'admin_post_nopriv_' . RC_ENQUIRY_ACTION, 'rc_handle_enquiry' );
/**
 * Validate, store and notify.
 */
function rc_handle_enquiry(): void {

	$redirect = isset( $_POST['rc_redirect'] )
		? esc_url_raw( wp_unslash( $_POST['rc_redirect'] ) )
		: home_url( '/contact/' );

	// Never redirect anywhere but back into this site.
	$redirect = wp_validate_redirect( $redirect, home_url( '/contact/' ) );

	if (
		! isset( $_POST['rc_nonce'] )
		|| ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['rc_nonce'] ) ), RC_ENQUIRY_ACTION )
	) {
		rc_enquiry_fail( $redirect, array( __( 'Your session expired. Please try again.', 'rian-cullet' ) ), array() );
	}

	/*
	 * Both traps below report success to the sender. Telling a bot that
	 * it failed only teaches it what to change next time.
	 */
	if ( ! empty( $_POST['rc_website'] ) ) {
		rc_enquiry_done( $redirect );
	}

	$submitted_at = isset( $_POST['rc_time'] ) ? (int) $_POST['rc_time'] : 0;
	if ( $submitted_at && ( time() - $submitted_at ) < RC_MIN_FILL_TIME ) {
		rc_enquiry_done( $redirect );
	}

	$fields = rc_enquiry_fields();
	$clean  = array();
	$errors = array();

	foreach ( $fields as $key => $field ) {
		$raw = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';

		if ( 'email' === $field['type'] ) {
			$value = sanitize_email( (string) $raw );
		} elseif ( 'textarea' === $field['type'] ) {
			$value = sanitize_textarea_field( (string) $raw );
		} else {
			$value = sanitize_text_field( (string) $raw );
		}

		if ( $field['required'] && '' === $value ) {
			/* translators: %s: field label */
			$errors[] = sprintf( __( '%s is required.', 'rian-cullet' ), $field['label'] );
		}

		if ( 'email' === $field['type'] && '' !== $value && ! is_email( $value ) ) {
			$errors[] = __( 'Please enter a valid email address.', 'rian-cullet' );
		}

		$clean[ $key ] = $value;
	}

	if ( $errors ) {
		rc_enquiry_fail( $redirect, $errors, $clean );
	}

	rc_store_enquiry( $clean );
	rc_notify_enquiry( $clean );

	rc_enquiry_done( $redirect );
}

/**
 * Redirect back reporting success.
 *
 * @param string $redirect Return URL.
 */
function rc_enquiry_done( string $redirect ): void {
	wp_safe_redirect( add_query_arg( 'enquiry', 'sent', $redirect ) . '#rc-enquiry' );
	exit;
}

/**
 * Redirect back with errors and the submitted values preserved.
 *
 * @param string               $redirect Return URL.
 * @param string[]             $errors   Error messages.
 * @param array<string,string> $old      Values to repopulate.
 */
function rc_enquiry_fail( string $redirect, array $errors, array $old ): void {

	$token = wp_generate_password( 12, false, false );

	set_transient(
		'rc_enq_' . $token,
		array(
			'errors' => $errors,
			'old'    => $old,
		),
		5 * MINUTE_IN_SECONDS
	);

	wp_safe_redirect(
		add_query_arg(
			array(
				'enquiry' => 'error',
				'rc_t'    => $token,
			),
			$redirect
		) . '#rc-enquiry'
	);
	exit;
}

/**
 * Persist the enquiry. This runs before the email is attempted, so a
 * mail failure can never lose the enquiry.
 *
 * @param array<string,string> $data Clean values.
 * @return int Post ID, or 0 on failure.
 */
function rc_store_enquiry( array $data ): int {

	$title = $data['name'];

	if ( '' !== $data['company'] ) {
		$title .= ', ' . $data['company'];
	}

	$post_id = wp_insert_post(
		array(
			'post_type'    => RC_ENQUIRY_CPT,
			'post_status'  => 'private',
			'post_title'   => $title,
			'post_content' => $data['message'],
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		return 0;
	}

	foreach ( array( 'email', 'phone', 'company', 'requirement' ) as $key ) {
		if ( '' !== $data[ $key ] ) {
			update_post_meta( $post_id, '_rc_' . $key, $data[ $key ] );
		}
	}

	return (int) $post_id;
}

/**
 * Email the enquiry to the site owner.
 *
 * The From address stays on the site domain so the message satisfies
 * SPF and DMARC. The visitor address goes in Reply-To, where replying
 * still reaches them but the sending domain is not spoofed.
 *
 * @param array<string,string> $data Clean values.
 */
function rc_notify_enquiry( array $data ): void {

	/**
	 * Filters the enquiry recipient.
	 *
	 * @param string $recipient Email address.
	 */
	$to = (string) apply_filters( 'rc_enquiry_recipient', get_option( 'admin_email' ) );

	/* translators: %s: sender name */
	$subject = sprintf( __( 'Website enquiry: %s', 'rian-cullet' ), $data['name'] );

	$fields = rc_enquiry_fields();
	$lines  = array();

	foreach ( $fields as $key => $field ) {
		if ( '' === $data[ $key ] ) {
			continue;
		}

		$value = $data[ $key ];

		if ( 'select' === $field['type'] && isset( $field['options'][ $value ] ) ) {
			$value = $field['options'][ $value ];
		}

		$lines[] = $field['label'] . ': ' . $value;
	}

	$lines[] = '';
	$lines[] = __( 'Sent from the Rian Cullet website enquiry form.', 'rian-cullet' );

	$host    = (string) wp_parse_url( home_url(), PHP_URL_HOST );
	$headers = array( 'From: ' . get_bloginfo( 'name' ) . ' <no-reply@' . $host . '>' );

	if ( is_email( $data['email'] ) ) {
		$headers[] = 'Reply-To: ' . $data['name'] . ' <' . $data['email'] . '>';
	}

	wp_mail( $to, $subject, implode( "\n", $lines ), $headers );
}
