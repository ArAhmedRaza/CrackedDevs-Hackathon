<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>How Worthy Am I?</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/jquery-terminal/jquery.terminal.min.css') }}">
</head>

<body>
    @yield('content')
    <!-- </main> -->

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/jquery-terminal/jquery.terminal.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/bootstrap-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/proper.min.js') }}"></script>
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

            var mergedArray = [];
            var questionIndex = 0;

            // Function to ask a question
            function askQuestion(index) {
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
                            for (var i = 0; i < questions.length; i++) {
                                var question = questions[i];
                                var answer = userAnswers[i];
                                mergedArray.push(question, answer);
                            }
                            $.ajax({
                                url: 'http://localhost/CrackedDevs-Hackathon/public/post-answers',
                                method: 'POST',
                                data: {
                                    answers: mergedArray
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    // Apply custom styling to the API response
                                    this.echo("Result: ", {
                                        cssClass: 'bold-text blue-text',
                                        finalize: function(div) {
                                            div.html(response);
                                        }
                                    });

                                    setTimeout(function() {
                                        //your code to be executed after 1 second
                                    }, 1000);

                                    this.echo("Here are some Job Recommandationn for You!");

                                    getjobs().then(function(jobsResponse) {
                                        if (Array.isArray(jobsResponse) && jobsResponse.length > 0) {
                                            // Display each job in the terminal
                                            jobsResponse.forEach(function(job) {
                                                this.echo('Job Title:' + job.title);
                                                this.echo("URL: " + job.url);
                                                this.echo("Company: " + job.company);
                                                this.echo("Min Salary: $" + (job.min_salary_usd ? job.min_salary_usd : "Not Given"));
                                                this.echo("Max Salary: $" + (job.max_salary_usd ? job.max_salary_usd : "Not Given"));
                                                this.echo("Location: " + (job.location_iso ? job.location_iso : "Not specified"));
                                            }.bind(this));
                                        } else {
                                            this.echo("No job details available.");
                                        }
                                    }.bind(this)).catch(function(error) {
                                        // Handle error from getjobs
                                        this.echo(error, {
                                            cssClass: 'bold-text green-text'
                                        });
                                    }.bind(this));

                                }.bind(this),
                                error: function(error) {
                                    // Apply custom styling to the error message
                                    this.echo("Error communicating with the API.", {
                                        cssClass: 'bold-text green-text'
                                    });
                                }.bind(this)
                            });


                        }
                    }
                }, {
                    prompt: questions[questionIndex] + '\n> ',
                    greetings: 'Answer Just 5 Simplest Questions to get Best Offers'
                });
            }

            // Start asking the first question
            askQuestion(0);
        });

        function getjobs() {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: 'http://localhost/CrackedDevs-Hackathon/public/get-jobs',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        resolve(response);
                    },
                    error: function(error) {
                        reject("Error getting Relevant Jobs. Please Try Again Later.");
                    }
                });
            });
        }
    </script>
</body>

</html>