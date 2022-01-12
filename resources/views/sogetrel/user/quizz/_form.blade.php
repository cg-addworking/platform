@if ($quizz->exists)
    <input type="hidden" name="quizz[id]" value="{{ $quizz->id }}">
@endif

@form_group([
    'horizontal' => true,
    'type'       => "select",
    'options'    => array_trans(array_mirror(sogetrel_passwork_quizz()::getAvailableStatuses()), 'sogetrel.user.passwork.quizz.status_'),
    'name'       => "quizz.status",
    'value'      => $quizz->status,
    'text'      => __('sogetrel.user.quizz._form.status'),
    'required'   => true,
])

@form_group([
    'horizontal' => true,
    'type'       => "select",
    'options'    => [
        'civil_engineering' => __('sogetrel.user.quizz._form.civil_engineering'),
        'linky' => __('sogetrel.user.quizz._form.linky'),
        'gazpar' => __('sogetrel.user.quizz._form.gazpar'),
        'Bureau d\'études' => [
            'study_manager'    => __('sogetrel.user.quizz._form.study_manager'),
            'drawer_drafter'   => __('sogetrel.user.quizz._form.drawer_drafter'),
            'telecom_picketer' => __('sogetrel.user.quizz._form.telecom_picketer'),
        ],
        'Réseau RTC' => [
            'erector_rigger_local_loop_cooper' => __('sogetrel.user.quizz._form.erector_rigger_local_loop_cooper'),
            'subscriber_technician_d3' => __('sogetrel.user.quizz._form.subscriber_technician_d3')
        ],
        'Réseau fibre optique' => [
            'local_loop' => __('sogetrel.user.quizz._form.local_loop'),
            'erector_rigger_d2' => __('sogetrel.user.quizz._form.erector_rigger_d2'),
            'optic_fiber' => __('sogetrel.user.quizz._form.optic_fiber'),
            'ftth' => __('sogetrel.user.quizz._form.ftth'),
            'optic_welder' => __('sogetrel.user.quizz._form.optic_welder')
        ],
        'Réseau télécom entreprise' => [
            'cpe_technician' => __('sogetrel.user.quizz._form.cpe_technician'),
        ],
        'Radio' => [
            'erector_rigger_radio' => __('sogetrel.user.quizz._form.erector_rigger_radio'),
        ]
    ],
    'name'       => "quizz.job",
    'value'      => $quizz->job,
    'text'      => __('sogetrel.user.quizz._form.job'),
    'required'   => true,
])

@form_group([
    'horizontal' => true,
    'type'       => "number",
    'min'        => 0,
    'max'        => 20,
    'step'       => 0.1,
    'name'       => "quizz.score",
    'value'      => $quizz->score,
    'text'      => __('sogetrel.user.quizz._form.score_obtained'),
    'required'   => true,
])

@form_group([
    'horizontal' => true,
    'type'       => "date",
    'name'       => "quizz.proposed_at",
    'value'      => $quizz->proposed_at,
    'text'      => __('sogetrel.user.quizz._form.send_it'),
    'required'   => true,
])

@form_group([
    'horizontal' => true,
    'type'       => "date",
    'name'       => "quizz.completed_at",
    'value'      => $quizz->completed_at,
    'text'      => __('sogetrel.user.quizz._form.completed_on'),
    'required'   => true,
])
