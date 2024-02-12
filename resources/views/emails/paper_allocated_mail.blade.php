<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$email_subject}}</title>
    <style>
        table{
            width:100%;
        }
        table tr th,td{
            border:1px solid black;
            text-align: center; 
        }
    </style>
</head>
<body>
    <h2>Dear {{$email_data['teacher']}},</h2>

    <p>Following paper setting has been allocated to you. You can access and upload to the Paper Setting Web Portal using url: <a href="https://web.gjuonline.ac.in/paper-setting">https://web.gjuonline.ac.in/paper-setting</a></p>
    <table>
        <thead>
            <tr>
                <th>Course</th>
                <th>Session</th>
                <th>Event</th>
                <th>SemYear</th>
                <th>Paper</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$email_data['course']}}</td>
                <td>{{$email_data['session']}}</td>
                <td>{{$email_data['event']}}</td>
                <td>{{$email_data['semYear']}}</td>
                <td>{{$email_data['paper']}}</td>
            </tr>
        </tbody>
    </table>

   

    <div style="margin-top: 20px; padding: 10px; background-color: #f2f2f2;">
        <p>For any technical query kindly contact us.</p>
        <p>Thanks & Regards,</p>
        <p>IT Cell</p>
    </div>

</body>
</html>
