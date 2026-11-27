<?php

return [
    'types' => [
        'full_time'  => 'Full-time',
        'contract'   => 'Contract',
        'internship' => 'Internship',
    ],

    'benefit' => [
        'title'       => 'Employee Benefits',
        'subtitle'    => 'We care about the well-being and growth of every team member.',
        'intro_title' => 'Grow with Mirota',
        'intro_text'  => 'Joining Mirota means being part of a company that has been in business since 1972, with a supportive working environment.',
        'items' => [
            ['icon' => '🏥', 'title' => 'Health Coverage',       'text' => '[Sample] BPJS health and employment social security coverage.'],
            ['icon' => '💰', 'title' => 'Religious Holiday Allowance', 'text' => '[Sample] Holiday allowance in accordance with regulations.'],
            ['icon' => '📚', 'title' => 'Training & Development', 'text' => '[Sample] Training programs to build your competencies.'],
            ['icon' => '📈', 'title' => 'Career Path',           'text' => '[Sample] Opportunities to grow based on performance and potential.'],
            ['icon' => '🤝', 'title' => 'Positive Workplace',    'text' => '[Sample] A family-like culture of mutual respect.'],
            ['icon' => '🥛', 'title' => 'Employee Products',     'text' => '[Sample] Discounts or allowances on Mirota products.'],
        ],
        'cta_title'  => 'Interested in Joining?',
        'cta_text'   => 'See our current openings and send in your application.',
        'cta_button' => 'View Openings',
    ],

    'team' => [
        'title'    => 'Our Team',
        'subtitle' => 'The people behind Mirota’s products and services.',
        'empty'    => 'Team information is not available yet.',
    ],

    'jobs' => [
        'title'      => 'Job Openings',
        'subtitle'   => 'Find your career opportunity at PT Mirota KSM.',
        'all'        => 'All',
        'view'       => 'View details',
        'deadline'   => 'Application deadline',
        'empty'      => 'There are no open positions at the moment.',
        'empty_hint' => 'Check back regularly, or get in touch through our contact page.',
        'closes_in'       => 'closes in :days days',
        'closes_tomorrow' => 'closes tomorrow',
        'closes_today'    => 'closes today',
    ],

    
    'job' => [
        'description'  => 'Job Description',
        'requirements' => 'Requirements',
        'back'         => 'Back to job openings',
        'apply_title'  => 'Apply for This Position',

        'form_title' => 'Job Application Form',
        'position'   => 'Position applied for',
        'full_name'  => 'Full Name',
        'address'    => 'Current residential address',
        'email'      => 'Email Address',
        'whatsapp'   => 'Contact number (WhatsApp)',

        'cv'         => 'CV (PDF)',
        'diploma'    => 'Diploma (PDF)',
        'attachment' => 'Supporting attachment (PDF) (optional)',

        'cv_name'         => 'CV',
        'diploma_name'    => 'Diploma',
        'attachment_name' => 'Supporting attachment',

        'file_hint' => 'PDF format, max. 2 MB.',

        'file_too_big' => 'The :name file is too large (:size MB). Maximum is 2 MB. Please choose a smaller file.',
        'file_bad_type' => 'The :name file format is not accepted. Use a PDF file.',

        'error_files_hint' => 'Note: please select the files (CV, Diploma, Attachment) again, since they are not kept when the page reloads.',

        'err_required' => 'The :name file is required.',
        'err_max'      => 'The :name file exceeds the limit. Maximum is 2 MB.',
        'err_upload'   => 'Failed to upload :name. The file size probably exceeds the 2 MB limit. Please choose a smaller file.',
        'err_type'     => 'The :name file format is not accepted. Use a PDF file.',

        'privacy' => 'Your data and CV are only used for the recruitment process. Read our',
        'submit'  => 'Submit Application',
        'sending' => 'Sending...',
        'error_summary' => 'The application could not be submitted. Please check the following:',
    ],


    'apply_success' => 'Thank you! We have received your application. Our team will contact you if your profile is a match.',
];