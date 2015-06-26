<?php
namespace lib;

class Mailer {
    public static function ses_invite_mail( $data ) {
        $html = '<h2>User Invite</h2><div>' .
            "<a href='" . url('project/invite', array('token' => $data['token'])) . "'>" . 
            url('project/invite', array('token' => $data['token'])) . 
            "</a>.<br/>This link will expire in " . date("Y-m-d H:i:s", $data['expire']) . 
            " . </div>";
        $text = "User Invite \n " . url('project/invite', array('token' => $data['token'])) . "\n This link will expire in " . date("Y-m-d H:i:s", $data['expire']) ;
        return self::send( 'User Invite', $data['email'], $html, $text );
    }
    
    public static function ses_join_project_remind_email( $data ) {
        $user = $data['user'];
        $project = $data['project'];
        $html = '<h2>Join Project ' . $project->name . '</h2><div>' .
            $user->first_name . " " . $user->last_name . " invite you to join " . $project->name . "; Click on the link<a href='" . $data['project_url'] . "'>" . $data['project_url'] . "</a> to enter the project</div>";
        $text = $user->first_name . " " . $user->last_name . " invite you to join " . $project->name . "; Click on the link " . $data['project_url'] . " to enter the project";
        return self::send( 'Join Project Prompt', $data['email'], $html, $text );
    }

    public static function ses_comment_email( $data ) {

        $html = '<h2>' . $data['title'] .'</h2>' .
        '<div>' . $data['content'] . '<p><a href="' . $data['url'] . '">View this on DevelopSpec</a></p></div>';
        $text = $data['title'] . "\n" . $data['content'] . "\n" . "Click on the link " . $data['url'] . " to view this on DevelopSpec";
        return self::send( $data['subject'], $data['emails'], $html, $text, array( '"DeepDevelop" <webmaster@deepdevelop.com>' ) , '"DeepDevelop" <webmaster@deepdevelop.com>' );
    }

    public static function send( $subject, $email, $html, $text, $reply = array( '"DeepDevelop" <webmaster@deepdevelop.com>' ) , $source = '"DeepDevelop" <webmaster@deepdevelop.com>' ) {
        $ses = \App::make('aws')->get('Ses');
        $config = array(
            'Source' => $source,
            'Destination' => array(
                'ToAddresses' => is_array($email) ? $email : [ '<' . $email . '>' ],
            ),
            'Message' => array(
                'Subject' => array(
                    'Data' => $subject,
                    'Charset' => 'utf-8',
                ),
                'Body' => array(
                    'Text' => array(
                        'Data' => $text,
                        'Charset' => 'utf-8',
                    ),
                    'Html' => array(
                        'Data' => $html,
                        'Charset' => 'utf-8',
                    ),
                ),
            ),
            'ReplyToAddresses' => $reply,
        );
        return $ses->sendEmail( $config );
    }
}