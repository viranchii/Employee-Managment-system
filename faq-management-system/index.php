<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ Management System</title>
    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--Google Font-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!--Stylesheet-->
    <style>
        *,
        *:before,
        *:after{
            padding: 0;
            margin: 0;
            box-sizing: border-box; 
            font-family: "Poppins",sans-serif;
        }

        body{
            background-color: #4fb6ff;
        }

        .container{
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-top: 50px;
            width: 80%;
            min-width: 500px;
        }

        .title-container > h1 {
            color: #ffffff;
            font-weight: bold;
            font-size: 50px;
            text-shadow: 1px 1px #000;
        }

        .title-container > button {
            font-size: 15px;
            width: 170px;
        }

        .wrapper {
            background-color: #ffffff;
            margin-bottom: 20px;
            padding: 15px 40px;
            border-radius: 5px;
            box-shadow: 0 15px 25px rgba(0,0,50,0.2);
        }

        .toggle {
            width: 100%;
            background-color: transparent;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 16px;
            color: #111130;
            font-weight: 500;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 15px 0;
        }

        .content{
            position: relative;
            font-size: 14px;
            text-align: justify;
            line-height: 30px;
            height: 0;
            overflow: hidden;
            transition: all 1s;
        }

        .action-button img {
            width: 15px;
        }
    </style>
</head>
<body>



    <div class="container">
        <div class="title-container text-center mb-3">
            <h1>Frequently Asked Questions</h1>
            <div class="buttons">
                <button class="btn btn-dark" data-toggle="modal" data-target="#addFaqModal">Add FAQ</button>
                <button class="btn btn-success" onclick="showAllActionButtons()">Manage FAQ</button>
            </div>
        </div>

        <?php 
            include("./conn/conn.php");
        
            $stmt = $conn->prepare("SELECT * FROM tbl_faq");
            $stmt->execute();

            $result = $stmt->fetchAll();

            foreach($result as $row) {
                $faqID = $row["tbl_faq_id"];
                $question = $row["question"];
                $answer = $row["answer"];
                ?>

                <div class="wrapper">
                    <button class="toggle">
                        <span id="question-<?= $faqID ?>"><?= $question ?></span>
                        <i class="fa-solid fa-plus icon"></i>
                    </button>
                    <div class="content">
                        <p id="answer-<?= $faqID ?>"><?= $answer ?></p>
                    </div>
                    <div class="action-button float-right" style="display: none;">
                        <button class="btn btn-primary btn-sm" onclick="updateFaq(<?= $faqID ?>)"><img src="https://cdn-icons-png.flaticon.com/512/1159/1159633.png" alt=""></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteFaq(<?= $faqID ?>)"><img src="https://cdn-icons-png.flaticon.com/512/1214/1214428.png" alt=""></button>
                    </div>
                </div>

                <?php
            }
        ?>


    </div>

    <!-- Modals -->

    <div class="modal fade" id="addFaqModal" tabindex="-1" aria-labelledby="addFaq" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFaq">Add FAQ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./endpoint/add-faq.php" method="POST">
                        <div class="form-group">
                            <label for="question">Frequently Asked Question:</label>
                            <input type="text" class="form-control" id="question" name="question">
                        </div>
                        <div class="form-group">
                            <label for="answer">Answer:</label>
                            <textarea class="form-control" name="answer" id="answer" cols="30" rows="7"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateFaqModal" tabindex="-1" aria-labelledby="updateFaq" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateFaq">Update FAQ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="./endpoint/update-faq.php" method="POST">
                        <input type="text" class="form-control" id="updateFaqID" name="tbl_faq_id">
                        <div class="form-group">
                            <label for="updateQuestion">Frequently Asked Question:</label>
                            <input type="text" class="form-control" id="updateQuestion" name="question">
                        </div>
                        <div class="form-group">
                            <label for="updateAnswer">Answer:</label>
                            <textarea class="form-control" name="answer" id="updateAnswer" cols="30" rows="7"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

    
    <!--Script-->
    <script>
        let toggles = document.getElementsByClassName('toggle');
        let contentDiv = document.getElementsByClassName('content');
        let icons = document.getElementsByClassName('icon');

        for(let i=0; i<toggles.length; i++){
            toggles[i].addEventListener('click', ()=>{
                if( parseInt(contentDiv[i].style.height) != contentDiv[i].scrollHeight){
                    contentDiv[i].style.height = contentDiv[i].scrollHeight + "px";
                    toggles[i].style.color = "#0084e9";
                }
                else{
                    contentDiv[i].style.height = "0px";
                    toggles[i].style.color = "#111130";
                }

                for(let j=0; j<contentDiv.length; j++){
                    if(j!==i){
                        contentDiv[j].style.height = "0px";
                        toggles[j].style.color = "#111130";

                    }
                }
            });
        }

        function showAllActionButtons() {
            let actionButtons = document.querySelectorAll('.action-button');

            actionButtons.forEach(button => {
                if (button.style.display === 'none' || button.style.display === '') {
                    button.style.display = 'block';
                } else {
                    button.style.display = 'none';
                }
            });
        }

        function updateFaq(id) {
            $("#updateFaqModal").modal("show");

            let updateQuestion = $("#question-" + id).html();
            let updateAnswer = $("#answer-" + id).html();

            $("#updateFaqID").val(id);
            $("#updateQuestion").val(updateQuestion);
            $("#updateAnswer").val(updateAnswer);
        }

        function deleteFaq(id) {
            if (confirm("Do you want to delete this faq?")) {
                window.location = "./endpoint/delete-faq.php?faq=" + id;
            }
        }
    </script>
</body>
</html>