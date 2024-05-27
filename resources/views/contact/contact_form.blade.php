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
      {{-- Blade syntax: Is a directive that is used to generate a
     CSRF (cross-site request forgery) token field in the form. 
     This field is used to protect the form from cross-site 
     request forgery attacks.

     Laravel automatically adds a hidden input field containing a
     token.This token is used to verify that the authenticated 
     user is the one actually making the requests to the application.
    --}}
      @csrf

      <div class="name-fields">

      {{--first name field--}}
        <div>
          <label class="field-label" for="first_name">First name<span class="required">*</span></label>
          <input class="text-field" type="text" id="first_name" name="first_name" maxlength="50" placeholder="Enter your first name" value="{{ old('first_name') }}">
          @error('first_name')
          <span class="error">{{ $message }}</span>
          @enderror
        </div>

        {{--last name field--}}
        <div class="last-name-field">
          <label class="field-label" for="last_name">Last name<span class="required">*</span></label>
          <input class="text-field" type="text" id="last_name" name="last_name" maxlength="50" placeholder="Enter you last name" value="{{ old('last_name') }}">
          @error('last_name')
          <span class="error">{{ $message }}</span>
          @enderror
          <br><br>
        </div>


      </div>

      {{--email field--}}
      <label class="field-label" for="email">Email<span class="required">*</span></label><br>
      <input class="text-field" type="email" id="email" name="email" size="40" maxlength="50" placeholder="Enter your email" value="{{ old('email') }}"><br>
  
      @error('email')
      <span class="error">{{ $message }}</span>
      @enderror
      @if(!$errors->has('email'))
      <span>example@example.com</span>
      @endif
      <br><br>

      {{--phone number (honeypot) field--}}
      <div class="phone-number">
      <label class="field-label " for="phone-number">Phone number<span class="required">*</span></label><br>
      <input class="text-field" type="tel" id="phone-number" name="phone_number" size="40" maxlength="50" placeholder="Enter your phone number" value="{{ old('phone_number') }}">
      <br><br>
      </div>
      
      {{--subject field--}}
      <label class="field-label" for="subject">Subject<span class="required">*</span></label><br>
      <input class="text-field" type="text" id="subject" name="subject" size=53 maxlength="100" placeholder="Enter the subject of your message" value="{{ old('subject') }}"><br>
      @error('subject')
      <span class="error">{{ $message }}</span>
      @enderror
      <br><br>

      {{--message field--}}
      <label class="field-label" for="message">Message<span class="required">*</span></label><br>
      <textarea class="text-field" id="message" name="message" rows="10" cols="53" maxlength="16535" placeholder="Enter your message here. Be as detailed as possible.">{{ old('message') }}</textarea><br>
      @if (session('success'))
      <div class="alert-success">
        {{ session('success') }}
      </div>
      @else
      @error('message')
      <span class="error">{{ $message }}</span>
      @enderror
      @endif
      <br><br>

      {{--submit button--}}
      <input id="submit" type="submit" value="Submit" style="color: blue">
    </form>


  </div>
</body>

</html>