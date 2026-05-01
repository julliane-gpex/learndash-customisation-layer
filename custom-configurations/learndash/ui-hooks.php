<?php
// Tooltip hover configuration for enrolled users only + rename locked tooltip
add_action('wp_footer', function () {

    if (!is_singular(array('sfwd-courses', 'sfwd-lessons', 'sfwd-topic'))) return;

    $user_id = get_current_user_id();
    $course_id = learndash_get_course_id(get_the_ID());

    $has_course_access = false;

    if ($user_id && $course_id) {
        $has_course_access = sfwd_lms_has_access($course_id, $user_id);
    }
    ?>

    <style>
        .learndash-wrapper .ld-item-list-item-preview { position: relative !important; }

        .learndash-wrapper .cz-hover-block {
            position: absolute !important;
            left: 22px !important;
            background-color: #ad0922 !important;
            color: #ffffff !important;
            padding: 4px 10px !important;
            border-radius: 4px !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            line-height: 1.2 !important;
            white-space: nowrap !important;
            z-index: 999 !important;
        }

        .learndash-wrapper .cz-hover-block.cz-has-topic-count { top: 72px !important; }
        .learndash-wrapper .cz-hover-block.cz-no-topic-count { top: 52px !important; }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Exception: disable LearnDash tooltip only for the Not Enrolled course status badge
        const notEnrolledStatus = document.querySelector(
            '.learndash-wrapper .ld-course-status-not-enrolled .ld-status.ld-tooltip'
        );

        if (notEnrolledStatus) {
            notEnrolledStatus.classList.remove(
                'ld-tooltip',
                'ld-tooltip--initialized',
                'ld-tooltip--position-right',
                'ld-tooltip--hidden'
            );

            const tooltipText = notEnrolledStatus.querySelector(
                '#ld-infobar__course-status-tooltip--not-enrolled'
            );

            if (tooltipText) {
                tooltipText.remove();
            }

            const trigger = notEnrolledStatus.querySelector('[aria-describedby]');

            if (trigger) {
                trigger.removeAttribute('aria-describedby');
                trigger.removeAttribute('tabindex');
            }
        }

        const hasCourseAccess = <?php echo $has_course_access ? 'true' : 'false'; ?>;

        if (hasCourseAccess) {
            const rows = document.querySelectorAll(
                '.learndash-wrapper .ld-item-list-item-preview'
            );

            rows.forEach(function (row) {
                if (row.querySelector('.cz-hover-block')) return;

                const block = document.createElement('div');
                block.className = 'cz-hover-block';
                block.textContent = 'Start / Continue this course';
                block.style.display = 'none';

                const rowText = row.textContent.toLowerCase();

                if (rowText.includes('topic')) {
                    block.classList.add('cz-has-topic-count');
                } else {
                    block.classList.add('cz-no-topic-count');
                }

                row.appendChild(block);

                row.addEventListener('mouseenter', function () {
                    block.style.display = 'inline-block';
                });

                row.addEventListener('mouseleave', function () {
                    block.style.display = 'none';
                });
            });
        }

        const tooltips = document.querySelectorAll('.ld-tooltip__text[role="tooltip"]');

        tooltips.forEach(function (tooltip) {
            if (tooltip.textContent.includes("don't currently have access")) {
                tooltip.textContent = 'Enroll now to access this course';
            }
        });
    });
    </script>

    <?php
});

// Change the text from the LearnDash Banner button "Log in to Enroll" "Only applies for unregistered users"
add_action('wp_footer', function () {
    if (!is_singular('sfwd-courses')) return;
    ?>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('button[data-ld-login-modal-trigger]');

        buttons.forEach(function (button) {
            if (button.textContent.trim() === 'Log In to Enroll') {
                button.textContent = 'GET STARTED';
            }
        });
    });
    </script>

    <?php
});

// Change LearnDash "Take this Course" button text + colour "Only applies for Registered users but not enrolled in the course"
add_action('wp_footer', function () {
    if (!is_singular('sfwd-courses')) return;
    ?>

    <style>
        .learndash-wrapper:not(.ld-registration__outer-wrapper):not(.learndash-wrapper--modern) #btn-join,
        .learndash-wrapper #btn-join.btn-join {
            background-color: #ad0922 !important;
            color: #ffffff !important;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const joinBtn = document.querySelector('#btn-join');

        if (joinBtn && joinBtn.value.trim() === 'Take this Course') {
            joinBtn.value = 'GET STARTED';
        }
    });
    </script>

    <?php
});