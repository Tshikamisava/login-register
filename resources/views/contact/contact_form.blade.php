<!DOCTYPE html>
<html>

<head>
  <link href="{{ asset('css/contact_form.css') }}" rel="stylesheet">
  <title>Contact Form</title>
</head>

<body>
  <div class="contact-form">
    <h1>Contact us</h1>
    <form action="/contact-form" method="POST">
      <!-- Blade syntax: Is a directive that is used to generate a
     CSRF (cross-site request forgery) token field in the form. 
     This field is used to protect the form from cross-site 
     request forgery attacks.

     Laravel automatically adds a hidden input field containing a
     token.This token is used to verify that the authenticated 
     user is the one actually making the requests to the application.
    -->
      @csrf

      <div class="name-fields">
        <div>
          <label class="field-label" for="first_name">First name</label>
          <input class="text-field" type="text" id="first_name" name="first_name" maxlength="50" placeholder="Enter your first name" value="{{ old('first_name') }}">
          @if ($errors->has('first_name'))
          <span class="error">{{ 'Your first name is required.' }}</span>
          @endif
        </div>
        <div class="last-name-field">
          <label class="field-label" for="last_name">Last name</label>
          <input class="text-field" type="text" id="last_name" name="last_name" maxlength="50" placeholder="Enter you last name" value="{{ old('last_name') }}">
          @if ($errors->has('last_name'))
          <span class="error">{{ 'Your last name is required.' }}</span>
          @endif
          <br><br>
        </div>


      </div>

      <label class="field-label" for="email">Email</label><br>
      <input class="text-field" type="email" id="email" name="email" size="40" maxlength="50" placeholder="Enter your email" value="{{ old('email') }}"><br>
      @if ($errors->has('email'))
      <span class="error">{{ 'Enter a valid email address.' }}</span>
      @else
      <span>example@example.com</span>
      @endif
      <br><br>
      <label class="field-label" for="subject">Subject</label><br>
      <input class="text-field" type="text" id="subject" name="subject" size=53 maxlength="100" placeholder="Enter the subject of your message" value="{{ old('subject') }}"><br>
      @if ($errors->has('subject'))
      <span class="error">{{ 'The subject is required (atleast 3 characters)' }}</span>
      @endif
      <br><br>
      <label class="field-label" for="message">Message</label><br>
      <textarea class="text-field" id="message" name="message" rows="10" cols="53" maxlength="16535" placeholder="Enter your message here. Be as detailed as possible.">{{ old('message') }}</textarea><br>
      @if (session('success'))
      <div class="alert-success">
        {{ session('success') }}
      </div>
      @elseif ($errors->has('message'))
      <span class="error">{{ 'The message is required (atleast 20 characters)' }}</span>
      @endif
      <br><br>
      <input id="submit" type="submit" value="Submit" style="color: blue">
    </form>


  </div>
</body>

</html>