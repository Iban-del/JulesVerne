<?php
namespace EnseignantEnseignement\Modele\Filter;

use Laminas\InputFilter\InputFilter;
use Laminas\Filter;
use Laminas\Validator;
use PhpParser\Node\Stmt\Return_;

class EnseignantFilter extends InputFilter {

    public function FilterForm()
    {

        $this->add([
            "name"=>"id",
            "required"=>false,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\ToInt::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"L'id doit être un entier"
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'lastname',
            'required' => true,
            'filters'=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class],
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ Nom ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\StringLength::class,
                    "options"=>[
                        "min"=>2,
                        "max"=>100,
                        "messages"=>[
                            Validator\StringLength::TOO_SHORT =>"Le nom est trop court",
                            Validator\StringLength::TOO_LONG=>"Le nom est trop long"
                        ]
                    ]
                ]
                
            ]
        ]);

        $this->add([
            'name' => 'firstname',
            'required' => true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class],
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ Prenom ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\StringLength::class,
                    "options"=>[
                        "min"=>2,
                        "max"=>100,
                        "messages"=>[
                            Validator\StringLength::TOO_SHORT =>"Le prenom est trop court",
                            Validator\StringLength::TOO_LONG=>"Le prenom est trop long"
                        ]
                    ]
                ],
                    
            ]
        ]);

        $this->add([
            'name' => 'email',
            'required' => true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ Mail ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\EmailAddress::class,
                    "options"=>[
                        "messages"=>[
                            Validator\EmailAddress::INVALID_FORMAT=>"L'adresse mail n'est pas valide"
                        ]
                    ]
                ],
                
            ]
        ]);

        $this->add([
            'name' => 'password',
            'required' => true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
            ],
            "validators"=>[

                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le mot da passe ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\Regex::class,
                    "options"=>[
                        "pattern"=>"/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/",
                        "messages"=>[
                            Validator\Regex::NOT_MATCH=>"Le mot de passe doit contenir au moins:<br>- une majuscule<br>- un caractère spésial<br>- 8 caractères"
                        ]
                    ],
                   
                ],

            ]
        ]);

        $this->add([
            'name' => 'UcMax',
            'required' => true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                       "messages"=>[
                           Validator\NotEmpty::IS_EMPTY=>"Le nombre d'Uc doit être définie"
                       ]
                    ]
               ],
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS => "Le nombre Uc max doit etre entier"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\NumberComparison::class,
                    "options"=>[
                        "min"=>0,
                        "messages"=>[
                            Validator\NumberComparison::ERROR_NOT_LESS_INCLUSIVE=>"Le nombre d'uc ne peut être inférieur a 0"
                        ]

                    ]
                ]
                
            ]
           
        ]);

        $this->add([
            'name' => 'idStatut',
            'required' => true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le statut doit être définie"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"Erreur de Statut"
                        ]
                    ]
                ],
                
            ]
            
        ]);

        $this->add([
            'name' => 'idRole',
            'required' => true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le Rôle doit être définie"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"Erreur de Rôle"
                        ]
                    ]
                ],
                
            ]
            
        ]);

        $this->add([
            'name' => 'GCM',
            'required' => false,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\ToInt::class],
            ],
            "validators"=>[
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"Le Groupe CM doit être un entier"
                        ]
                    ]
                ]
            ]
           
        ]);

        $this->add([
            'name' => 'GTD',
            'required' => false,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\ToInt::class],
            ],
            "validators"=>[
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"Le Groupe TD doit être un entier"
                        ]
                    ]
                ]
            ]
        ]);

        $this->add([
            'name' => 'GTP',
            'required' => false,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\ToInt::class],
            ],
            "validators"=>[
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS=>"Le Groupe TP doit être un entier"
                        ]
                    ]
                ]
            ]
        ]);

        return $this;
    }

    public function filterEmail(){

        $this->add([
            'name' => 'email',
            'required' => true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
                ["name"=>Filter\StringTrim::class]
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le champ Mail ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\EmailAddress::class,
                    "options"=>[
                        "messages"=>[
                            Validator\EmailAddress::INVALID_FORMAT=>"L'adresse mail n'est pas valide"
                        ]
                    ]
                ],
                
            ]
        ]);

        return $this;
    }


    public function filterPassword(){

        $this->add([
            'name' => 'password',
            'required' => true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
            ],
            "validators"=>[

                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                        "messages"=>[
                            Validator\NotEmpty::IS_EMPTY=>"Le mot da passe ne doit pas être vide"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\Regex::class,
                    "options"=>[
                        "pattern"=>"/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/",
                        "messages"=>[
                            Validator\Regex::NOT_MATCH=>"Le mot de passe doit contenir au moins:<br>- une majuscule<br>- un caractère spésial<br>- 8 caractères"
                        ]
                    ],
                   
                ],

            ]
        ]);

        return $this;

    }


    public function filterUc(){

        $this->add([
            'name' => 'UcMax',
            'required' => true,
            "filters"=>[
                ["name"=>Filter\HtmlEntities::class],
            ],
            "validators"=>[
                [
                    "name"=>Validator\NotEmpty::class,
                    "options"=>[
                       "messages"=>[
                           Validator\NotEmpty::IS_EMPTY=>"Le nombre d'Uc doit être définie"
                       ]
                    ]
               ],
                [
                    "name"=>Validator\Digits::class,
                    "options"=>[
                        "messages"=>[
                            Validator\Digits::NOT_DIGITS => "Le nombre Uc max doit etre entier"
                        ]
                    ]
                ],
                [
                    "name"=>Validator\NumberComparison::class,
                    "options"=>[
                        "min"=>0,
                        "messages"=>[
                            Validator\NumberComparison::ERROR_NOT_LESS_INCLUSIVE=>"Le nombre d'uc ne peut être inférieur a 0"
                        ]

                    ]
                ]
                
            ]
           
        ]);

        return $this;
    }
}
