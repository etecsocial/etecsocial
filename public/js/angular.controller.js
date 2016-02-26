var app = angular.module('app', []);
app.controller('infoGroupCtrl', function ($scope) {

    $scope.infos = [
        {
            nome: 'Prova de Química',
            descricao: 'Estudo complementar para prova',
            participantes: '31',
            discussoes: '4',
            perguntas: '6'
            
        }
               ];
});

app.controller('configGroupCtrl', function ($scope) {

    $scope.dados = [
        {
            intuito: 'Aqui, neste exato lugar, vai ter um texto que ala brevemente pra que o grupo foi criado, sja para estudar para uma prova, seja para apresentção de teabalho, ou para o raio que o parta.',
            nome: 'Prova de Química',
            expiracao: '31/06/2015'
/*            alunos: [
                {
                foto: 'images/users/user.jpg',
                nome: 'John Doe'
                },                {
                foto: 'images/users/user1.jpg',
                nome: 'John Doe'17:54 12/08/2015
                },                {
                foto: 'images/users/user2.jpg',
                nome: 'John Doe'
                },                {
                foto: 'images/users/user3.jpg',
                nome: 'John Doe'
                },                {
                foto: 'images/users/user4.jpg',
                nome: 'John Doe'
                },                {
                foto: 'images/users/user5.jpg',
                nome: 'John Doe'
                },                {
                foto: 'images/users/user6.jpg',
                nome: 'John Doe'
                },                {
                foto: 'images/users/user7.jpg',
                nome: 'John Doe'
                },                {
                foto: 'images/users/user8.jpg',
                nome: 'John Doe'
                }
            ],
            professores: [
                {
                foto: 'images/users/user.jpg',
                nome: 'John Doe'
                },                {
                foto: 'images/users/user1.jpg',
                nome: 'John Doe'
                },                {
                foto: 'images/users/user2.jpg',
                nome: 'John Doe'
                }
               ]*/
        }
               ];
});

app.controller('todoCtrl', function ($scope) {
    $scope.todos = 'array';

    $scope.todos = [
        {
            text: 'Definir ordem de apresentação',
            date: '22/03/2015',
            day: 'Ontem',
            id: 1,
            done: true
                },
        {
            text: 'Separar conteúdo',
            date: '22/03/2015',
            day: 'Amanhã',
            id: 2,
            done: false
            }, {
            text: 'Fazer os slides',
            date: '22/03/2015',
            day: '3 dias',
            id: 3,
            done: false
            }
            ];


    $scope.saveTodo = function () {
        var dateAtual = moment().format("L");
        $scope.todos.push({
            done: false,
            text: $scope.formTodoText,
            date: dateAtual,
            day: 'Hoje'
        });
        $scope.formTodoText = '';
    };
});


app.controller('ComentController', function(){

this.coment = {};
    
    this.addComent = function(post){
    
        post.coments.push($sope.posts);
        this.coment = {};
        
    };
    
    

});



app.controller('postCtrl', function ($scope) {



    $scope.posts = [


        {
            autor: 'John Doe',
            titulo: 'A hipótese de Birch e Swinnerton-Dyer',
            post: 'Ao carregarmos esse HTML no navegador e digitarmos qualquer coisa no input, o parágrafo é atualizado automagicamente.Ao carregarmos esse HTML no navegador e digitarmos qualquer coisa no input, o parágrafo é atualizado automagicamente.Ao carregarmos esse HTML no navegador e digitarmos qualquer coisa no input, o parágrafo é atualizado automagicamente.Ao carregarmos esse HTML no navegador e digitarmos qualquer coisa no input, o parágrafo é atualizado automagicamente. Perceberam que até agora não escrevemos nenhum código JavaScript? A propriedade ng-model funciona como um canal entre a nossa view e o form. Ela pode ser utilizada em inputs do tipo texto, selects, textareas, checkboxes e radio buttons. O model, seus dados e suas validações ficam automaticamente disponíveis no escopo da nossa aplicação, como veremos a seguir.Learn to use Angular.js by adding behavior to your HTML and speeding up your application responsiveness. Get ready to dive into all the angles of Angular.js!Learn to use Angular.js by adding behavior to your HTML and speeding up your applications responsiveness. Get ready to dive into all the angles of Angular.js!',
            data: '22/03/2015',
            tags: '#Dúvida #Matemática',
            coments: [

                {
                    nome: 'Hirlei Felicidade M. Assunção',
                    com: 'Por isso você vai ser sempre um lixo, um imprestável, nada. Sua vida não passará de um imenso vazio.',
                    foto: 'images/users/user2.jpg'
                },
                {
                    nome: 'Guilherme Caruso',
                    com: 'Por isso você vai ser sempre um lixo, um imprestável, nada. Sua vida não passará de um imenso vazio.',
                    foto: 'images/users/user3.jpg'
                }
            ]
            
            
        },

        {
            autor: 'X',
            titulo: 'x'
            },

        {
            autor: 'X',
            titulo: 'x'
            }


    ];


    /*    $scope.posts = [
            {
                post: [{
                        autor: 'John Doe',
                        titulo: 'A hipótese de Birch e Swinnerton-Dyer',
                        post: 'Ao carregarmos esse HTML no navegador e digitarmos qualquer coisa no input, o parágrafo é atualizado automagicamente. Perceberam que até agora não escrevemos nenhum código JavaScript? A propriedade ng-model funciona como um canal entre a nossa view e o form. Ela pode ser utilizada em inputs do tipo texto, selects, textareas, checkboxes e radio buttons. O model, seus dados e suas validações ficam automaticamente disponíveis no escopo da nossa aplicação, como veremos a seguir.Learn to use Angular.js by adding behavior to your HTML and speeding up your application responsiveness. Get ready to dive into all the angles of Angular.js!Learn to use Angular.js by adding behavior to your HTML and speeding up your applications responsiveness. Get ready to dive into all the angles of Angular.js!',
                        data: '22/03/2015',
                        tags: '#Dúvida #Matemática',
                        coments: [
                            {
                                nome: 'Hirlei Felicidade M. Assunção',
                                com: 'Por isso você vai ser sempre um lixo, um imprestável, nada. Sua vida não passará de um imenso vazio.',
                                foto: 'images/users/user2.jpg'
                        }, {
                                nome: 'Guilherme Caruso',
                                com: 'Por isso você vai ser sempre um lixo, um imprestável, nada. Sua vida não passará de um imenso vazio.',
                                foto: 'images/users/user3.jpg'
                        }, {
                                nome: 'Matheus Dias',
                                com: 'Por isso você vai ser sempre um lixo, um imprestável, nada. Sua vida não passará de um imenso vazio.',
                                foto: 'images/users/user4.jpg'
                        }, {
                                nome: 'Guilherme Caruso',
                                com: 'Por isso você vai ser sempre um lixo, um imprestável, nada. Sua vida não passará de um imenso vazio.',
                                foto: 'images/users/user3.jpg'
                        }, {
                                nome: 'Matheus Dias',
                                com: 'Por isso você vai ser sempre um lixo, um imprestável, nada. Sua vida não passará de um imenso vazio.',
                                foto: 'images/users/user4.jpg'
                        }
                        }]

                        ]
            }
                   ];*/
    /*
        $scope.saveComent = function () {
            $scope.posts],
            
            
            
            .push({
                nome: 'Nome do Usuário Atual',
                com: $scope.formComentText,
                foto: 'images/users/user10.jpg'
            });
            $scope.formComentText = '';
        };*/
});

app.controller('infoUserCtrl', function ($scope) {

    $scope.infoUser = 'array';
    $scope.infoUser = [
        {
            nome: 'Johngg',
            sobrenome: 'Peter',
            interesse: 'Um breve texto que descreva o interesse pelos futuros estudos e/ou carreira que o aluno pretende seguir.',
            telefone: '22/03/2015',
            email: 'Roger.waters@etec.sp.gov.br',
            aniversario: '12 de Outubro',
            status: 'Meus filhos terão computadores, sim, mas antes terão livros. Sem livros, sem leitura, os nossos filhos serão incapazes de escrever - inclusive a sua própria história.',
            ultAtualizacaoStatus: '24/06/2015 às 16h'
        }
               ];
});






$('#psb').perfectScrollbar();

//$("#psb").nanoScroller();
