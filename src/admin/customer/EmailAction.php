<?php

namespace demo\admin\customer;

use koolreport\dashboard\admin\actions\Action;
use koolreport\dashboard\inputs\TextArea;
use koolreport\dashboard\inputs\TextBox;
use koolreport\dashboard\notifications\Note;
use koolreport\dashboard\validators\NumericValidator;
use koolreport\dashboard\validators\RequiredFieldValidator;

class EmailAction extends Action
{
    protected function onCreated()
    {
        $this->title("Email")
        ->type("warning")
        ->icon("far fa-envelope");
    }

    protected function handle($form, $models)
    {
        $subject = $form->input("subject")->value();
        $content = $form->input("content")->value();
        
        if($subject=="" && $content=="") {
            return Note::danger("You have an empty email!","Not sent");
        }

        // In real applications, we will send email here

        $numberOfPersons = $models->count();
        if($numberOfPersons==1) {
            return Note::success("The email has been sent to <b>".$models->get(0,"customerName")."</b>","Email sent!");
        }
        return Note::success("Has emailed to $numberOfPersons persons","Email sent!");
    }

    protected function form()
    {
        return Action::modalForm([
            "Subject"=>TextBox::create("subject")->placeHolder("Subject"),
            "Content"=>TextArea::create("content")->placeHolder("Content"),
        ])
        ->validators([
            NumericValidator::create()->inputToValidate("subject")
        ])
        ->confirmButtonText("Send");
    }
}