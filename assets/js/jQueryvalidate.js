
$(document).ready(function () {
    $.validator.addMethod("regex", function(value, element, pattern) {
        return this.optional(element) || pattern.test(value);
    }, "Format incorrect.");

    $("form").validate({
        rules: {
            name: {
                required: true,
                minlength: 3,
                regex: /^[A-Za-zÀ-ÿ\s]+$/
            },
            email: {
                required: true,
                email: true
            },
            
            date_dernier_don: {
                required: true,
                date: true
            },
            password: {  
                required: true,
                minlength: 6,
                regex: /^(?=.*[A-Z])(?=.*\d)/
            },
            adress: {
                required: true,
                minlength: 5
            },
            phone: {
                required: true,
                minlength: 8,
                maxlength:8,
                 digits: true,
                 regex: /^(2|5|4|9)\d{7}$/
            },
            type_don: {
                required: true,
                pattern: /^(financière|equipments)$/ 
            },
            handicap_type: {
                required: true,
                pattern: /^(handicap moteur|handicap multiple)$/ 
            },
            needs:{
                required:true,
            },
            amount: {
                required: true,
                min: 1
            },
            payment_method: {
                required: true
            },
            card_number: {
                required: function() {
                    return $('#payment_method').val() === 'credit_card';
                },
                minlength: 15,
                maxlength: 15,
                digits: true
            },
            expiry_date: {
                required: function() {
                    return $('#payment_method').val() === 'credit_card';
                }
            },
            security_code: {
                required: function() {
                    return $('#payment_method').val() === 'credit_card';
                },
                minlength: 3,
                maxlength: 3,
                digits: true
            },
            bank_name: {
                required: function() {
                    return $('#payment_method').val() === 'bank_transfer';
                }
            },
            other_bank: {
                required: function() {
                    return $('#bank_name').val() === 'Other';
                }
            },
            bank_account: {
                required: function() {
                    return $('#payment_method').val() === 'bank_transfer';
                },
                pattern: /^TN\d{10}$/,
                minlength: 12,
                maxlength: 12
            }
        },
        messages: {
            name: {
                required: "Veuillez entrer votre nom",
                minlength: "Votre nom doit comporter au moins 3 caractères",
                regex: "Le nom ne doit contenir que des lettres"
            },
            email: {
                required: "Veuillez entrer votre adresse e-mail",
                email: "Veuillez entrer une adresse e-mail valide"
            },
            date_dernier_don: {
                required: "Veuillez entrer une date",
                email: "Veuillez entrer une date valide"
            },
            password: {
                required: "Veuillez fournir un mot de passe",
                minlength: "Votre mot de passe doit comporter au moins 6 caractères",
                regex: "Le mot de passe doit contenir au moins une lettre majuscule et un chiffre"
            },
          
            adress: {
                required: "Veuillez entrer votre adresse",
                minlength: "L'adresse doit comporter au moins 5 caractères"
            },
            phone: {
                required: "Veuillez entrer votre numéro de téléphone",
                minlength: "Le numéro de téléphone doit comporter 8 chiffres",
                maxlength: "Le numéro de téléphone doit comporter 8 chiffres",
                digits: "Veuillez entrer un numéro de téléphone valide",
                regex: "Le numéro de téléphone doit commencer par 2, 5, 4 ou 9"
            },type_don: {
                required: "Ce champ est obligatoire.",
                pattern: "Le type de don doit être 'financière' ou 'equipments'."
            },
            handicap_type: {
                required: "Ce champ est obligatoire.",
                pattern: "Le type de don doit être 'handicap moteur' ou 'handicap multiple'."
            },
            needs:{
                required: "Ce champ est obligatoire."
            },
            amount: {
                required: "Veuillez entrer un montant pour le don",
                min: "Le montant doit être supérieur à zéro"
            },
            payment_method: "Veuillez sélectionner un mode de paiement",
            card_number: {
                required: "Veuillez entrer le numéro de votre carte",
                minlength: "Le numéro de carte doit être exactement de 15 chiffres",
                maxlength: "Le numéro de carte doit être exactement de 15 chiffres",
                digits: "Veuillez entrer un numéro de carte valide"
            },
            expiry_date: "Veuillez entrer une date d'expiration valide",
            security_code: {
                required: "Veuillez entrer le code de sécurité",
                minlength: "Le code de sécurité doit être exactement de 3 chiffres",
                maxlength: "Le code de sécurité doit être exactement de 3 chiffres",
                digits: "Veuillez entrer un code de sécurité valide"
            },
            bank_name: "Veuillez sélectionner une banque",
            other_bank: "Veuillez entrer le nom de la banque",
            bank_account: {
                required: "Veuillez entrer un numéro de compte bancaire",
                pattern: "Le numéro de compte doit commencer par 'TN' et avoir 10 chiffres",
                minlength: "Le numéro de compte doit avoir 12 caractères",
                maxlength: "Le numéro de compte doit avoir 12 caractères"
            }
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});
