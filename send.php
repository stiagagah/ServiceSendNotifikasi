<html>
    <head>
        <title>Notifikasi Firebase</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <style>
            input[type=text], select {
                width: 100%;
                padding: 12px 20px;
                margin: 8px 0;
                display: inline-block;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            input[type=submit] {
                background-color: #4CAF50;
                color: white;
                padding: 14px 20px;
                margin: 8px 0;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }

            input[type=submit]:hover {
                background-color: #45a049;
            }

        </style>
        
    </head>
    <body>
        <h3>Notifikasi Firebase</h3>

        <div>
          <form action="send.php" method="get">
            <label for="token">Firebase Token</label>
            <input type="text" id="token" name="token" placeholder="Input Token">

            <label for="message">Message</label>
            <input type="text" id="message" name="message" placeholder="Input Message">
            
            <input type="hidden" name="type" value="single" >
            <input type="submit" value="Kirim">
          </form>
            
            
          <form action="send.php">
            <label for="fname">Topics</label>
              
            <select name="topics">
              <option value="news">News</option>
              <option value="promo">Promo</option>
            </select>

            <label for="lname">Message</label>
            <input type="text" id="message" name="message" placeholder="Input Message">
              
            <input type="hidden" name="type" value="topics" >
            <input type="submit" value="Kirim">
          </form>
            
        </div>

        <?php
        // Enabling error reporting
        error_reporting(-1);
        ini_set('display_errors', 'On');
 
        $type = isset($_GET['type']) ? $_GET['type'] : '';
        
        $fields = NULL;
        
        if($type == "single") {
            $token = isset($_GET['token']) ? $_GET['token'] : '';
            $message = isset($_GET['message']) ? $_GET['message'] : '';
            
            $res = array();
            $res['body'] = $message;
            
            $fields = array(
                'to' => $token,
                'notification' => $res,
            );
        
            echo 'FCM Reg Id : '. $token . '<br/>Message : ' . $message;
        }else if($type == "topics") {
            $topics = isset($_GET['topics']) ? $_GET['topics'] : '';
            $message = isset($_GET['message']) ? $_GET['message'] : '';
            
            $res = array();
            $res['body'] = $message;
            
            $fields = array(
                'to' => '/topics/' . $topics,
                'notification' => $res,
            );
            
            echo json_encode($fields);
            echo 'Topics : '. $topics . '<br/>Message : ' . $message;
        }
        
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
        $server_key = "AAAAuh6ONXE:APA91bEBg_6oxPnwk9pX9q9XvW_71PO-GB7AOXuPvEyK28CJnD_hQ6mWUzElDFRPGc09vYsD1pZgjjxbUiui-l3zJ2-LYWpixp76AfzL2Flf9kESt9Yd47behC2vktwS3Pbpgx6-WFUH-51qy9SWlemDu74RklyK5A";
        
        $headers = array(
            'Authorization: key=' . $server_key,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            echo 'Curl failed: ' . curl_error($ch);
        }
 
        // Close connection
        curl_close($ch);
               
        ?>
        
    </body>
</html>