<?php
$uri = explode("/", $_SERVER['REQUEST_URI'], PHP_URL_PATH);

$con = new mysqli("localhost", "user", "password", "questions", 9906);

if ( (isset($uri[2]) && $uri[2] != "questions") || !isset( $uri[3])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

switch ($_SERVER["REQUEST_METHOD"]){
    case "POST":
        $new_question = json_decode(file_get_contents('php://input'), TRUE);
        $my_query = "INSERT INTO questions (asked) VALUES ('". $new_question["asked"] . "')";
        $con->query($my_query) or die($con->error);
        $question_id = $con->insert_id;
        foreach ($new_question["answered"] as $answer) {
            $my_query = "INSERT INTO responses (answered, respondents, question_id) VALUES ('" . $answer["response"] .
             "','" . $answer["respondents"] . "'," . $question_id . ")";
            $con->query($my_query) or die($con->error);
        }
        break;
    case "GET":
        $my_query = "SELECT id, asked FROM questions WHERE id = " . $uri[3] . "";
        $result = $con->query($my_query) or die($con->error);
        echo json_encode($result->fetch_assoc());
        break;
    default:
        echo "Unsupported so far\n";
        echo $_SERVER["REQUEST_METHOD"];

}
?>