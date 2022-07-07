<?php 

/* @changelog 2022-07-06 [FIX] (Henintsoa) validation des champs telephones sur acf */
add_action('acfe/form/validation/form=form-contact', 'phoneFieldValidation', 10, 2);
add_action('acfe/form/validation/form=form-mini-cv', 'phoneFieldValidation', 10, 2);
add_action('acfe/form/validation/form=form-contact-agence', 'phoneFieldValidation', 10, 2);
add_action('acfe/form/validation/form=form-contact-express', 'phoneFieldValidation', 10, 2);
add_action('acfe/form/validation/form=form-devis', 'phoneFieldValidation', 10, 2);
add_action('acfe/form/validation/form=form-mini-devis', 'phoneFieldValidation', 10, 2);
add_action('acfe/form/validation/form=form-recruitment', 'phoneFieldValidation', 10, 2);

function phoneFieldValidation($form, $post_id){
    $phoneFieldKey = '';

    switch ($form['name']) {
        case (
            $form['name'] == "form-contact" || 
            $form['name'] == "form-contact-agence" || 
            $form['name'] == "form-devis" || 
            $form['name'] == "form-recruitment" ) :

            $phoneFieldKey = 'telephone';
            break;
        case ($form['name'] == "form-contact-express" || $form['name'] == "form-mini-devis") :
            $phoneFieldKey = 'phone';
            break;

        case $form['name'] == "form-mini-cv" :
            $phoneFieldKey = 'numero_telephone';
            break;
    }

    // Get field phone input value
    $phoneFieldValue = get_field($phoneFieldKey);

    if($phoneFieldValue != ''){
        if(!preg_match('/^[0-9]{10}+$/',  $phoneFieldValue))
        {
            // Add validation error
            acfe_add_validation_error($phoneFieldKey, $phoneFieldValue .' n\'est pas un numéro de téléphone valide.');  
        }
    } else {
        acfe_add_validation_error($phoneFieldKey, $phoneFieldValue .' La valeur Téléphone est requise.');
    }
}
