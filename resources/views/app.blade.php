<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How Worthy Am I?</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/jquery-terminal/jquery.terminal.min.css') }}">
</head>

<body>
    <!-- <main class="container"> -->
    @yield('content')
    <!-- </main> -->

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/jquery-terminal/jquery.terminal.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/bootstrap-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/proper.min.js') }}"></script>
    <!-- <script>
        $(function() {
            $('#terminal').terminal({},{
                greetings: 'Answer Some Questions and get Jobs, Roadmaps and Score for Your Career'
            });
        });
    </script> -->
    <script>
        $(document).ready(function() {
            // Array to store user answers
            var userAnswers = [];

            // Questions array with corresponding indexes
            var questions = [
                "Did you pursue any specific courses or certification relevant to your field?",
                "What is your work experience in your current or previous roles?",
                "What are your key skills and strengths?",
                "What aspects of your work do you find most fulfilling or enjoyable?",
                "Are there areas where you feel you could improve?"
            ];

            // Function to ask a question
            function askQuestion(index) {
                questionIndex = 0;
                $("#terminal").terminal(function(command) {
                    // Check if the user entered a response
                    if (command.trim() === "") {
                        this.echo("Please provide an answer for the question.");
                    } else {
                        // Store the user's answer
                        userAnswers[questionIndex] = command;
                        // Ask the next question or finish if all questions are answered

                        if (questionIndex < questions.length - 1) {
                            this.set_prompt(questions[questionIndex + 1] + '\n> ');
                            questionIndex++;
                        } else {
                            simulateLoading(function() {
                                this.echo("Generate Best Results for You...");
                            }.bind(this));
                            // You can now use the userAnswers array for further processing
                            console.log(userAnswers);
                        }
                    }
                }, {
                    prompt: questions[questionIndex] + '\n> ',
                    greetings: 'Answer Some Questions and get Jobs, Roadmaps and Score for Your Career'
                });
            }

            // Start asking the first question
            askQuestion(0);
        });

        // Function to simulate loading with dots
        function simulateLoading(callback) {
            var dots = 0;
            var loadingInterval = setInterval(function() {
                dots = (dots % 4) + 1;
                $("#terminal").terminal("Generate Best Results for You" + ".".repeat(dots));
            }, 500);

            // Execute the callback after a certain time (simulating processing time)
            setTimeout(function() {
                clearInterval(loadingInterval);
                callback();
            }, 2000);
        }
    </script>
</body>

</html>