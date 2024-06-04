<?php

namespace App\Http\Controllers\Contact;

use App\Models\ContactForm;
use App\Http\Controllers\Controller;
use App\Mail\ContactFormEmail;
use App\Rules\Recaptcha;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

class ContactFormController extends Controller
{


  // Show the contact form view
  public function showContactForm()
  {
    return view('contact.index');

  }

  public function showTestPage()
  {
    return view('contact.test');
    
  }

  // Store the contact form data
  public function submit()
  {
    $validations = [
      'first_name' => ['required', 'min:3', 'max:50'],
      'last_name' => ['required', 'min:1', 'max:50'],
      'email' => ['required', 'email', 'min:5', 'max:100'],
      'subject' => ['required', 'min:3', 'max:100'],
      'message' => ['required', 'min:20', 'max:10000'],
      'phone_number' => ['max:0'], // honeypot field should be empty
      'g-recaptcha-response' => ['required', new ReCaptcha]
    ];

    // Maximum validation error messages are not implemented here because the form fields on the user interface should limit maximum characters entered
    $errorMessages = [
      'first_name.required' => 'Your first name is required.',
      'first_name.min' => 'Your first name must be atleast 3 characters.',
      'last_name.required' => 'Your last name is required.',
      'email.required' => 'Your email address is required.',
      'email.email' => 'Please enter a valid email address.',
      'email.min' => 'Your email address must be atleast 5 characters.',
      'subject.required' => 'The subject is required.',
      'subject.min' => 'The subject must be atleast 3 characters.',
      'message.required' => 'The message is required.',
      'message.min' => 'The message must be atleast 20 characters.',
      'phone_number.max' => 'Dear ' . request('first_name') . ', Thanks for contacting us! We will get back to you soon.' /*honeypot pot sucsessful message to confuse bots*/,
      'g-recaptcha-response.required' => 'Please complete the reCAPTCHA.'
    ];

    $formData = request()->validate($validations, $errorMessages);

    // Disallow resubmission if form was already submitted
    Log::info($formData);

    $exists = ContactForm::where(
      [
        'first_name' => $formData['first_name'],
        'last_name' =>  $formData['last_name'],
        'email' =>  $formData['email'],
        'subject' =>  $formData['subject'],
        'message' =>  $formData['message'],
      ]
    )->exists();

    // Handling resubmission issue & submission
    if ($exists) {

      // User message for unallowed resubmission
      $resubmissionMessage = 'Dear ' . request('first_name') . ', Thank you for writing to us. We got your request and within 2 business days, we will get in touch.';

      return redirect()->route('contact-form')->withInput()->with('success', $resubmissionMessage);

    } else {
      // Submit the form data to the database (eloquent model)
      ContactForm::create($formData);

      // Testing Email sending
      /*$body = '<p>'. $formData['message']. '<p>';
      $subject = $formData['subject'] . ' - Test Email';
      $email = $formData['email'];

      Mail::raw($body, function ($message) use ($email, $subject) {
        $message->to($email)
          ->subject($subject);
      });

      Mail::html($body, function ($message) use ($email, $subject) {
        $message->to($email)
          ->subject($subject);
      });*/

      $email = new ContactFormEmail($formData);

      // Send the email
      Mail::to('MailTrap@gmail.com')->send($email);


      // User message for successful form submission
      $successMessage = 'Dear ' . request('first_name') . ', Thanks for contacting us! We will get back to you soon.';

      return redirect()->route('contact-form')->withInput()->with('success', $successMessage);
    }
  }
}
