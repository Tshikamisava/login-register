<!DOCTYPE html>
<html>

<head>
  <link href="{{ asset('backend/css/app.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/css/form.css') }}" rel="stylesheet">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <title>Contact Us</title>
</head>

<body>

  <div class="card p-4 sm:p-5">

    {{-- Heading --}}

    <p class="text-3xl font-semi text-slate-700 dark:text-navy-100">
      Contact Us
    </p>

    {{-- Form --}}

    <form method="POST" action="/contact-form">

      {{-- Blade syntax: Is a directive that is used to generate a
     CSRF (cross-site request forgery) token field in the form. 
     This field is used to protect the form from cross-site 
     request forgery attacks.

     Laravel automatically adds a hidden input field containing a
     token.This token is used to verify that the authenticated 
     user is the one actually making the requests to the application.
    --}}
      @csrf


      {{--Form Container--}}
      <div class="mt-4 space-y-4">

        {{-- BLOCK: First name, Last name, Phone --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

          {{-- First Name --}}
          <label class="block">
            <span>First name</span>
            <span class="relative mt-1.5 flex">
              <input class="form-input peer w-9/12 rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" type="text" id="first_name" name="first_name" placeholder="Enter your first name" value="{{ old('first_name') }}" maxlength="50">
              <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                <i class="far fa-user text-base"></i>
              </span>
            </span>
            @error('first_name')
            <span class="text-sm text-error">{{ $message }}</span>
            @enderror
          </label>

          {{-- Last Name --}}

          <label class="block">
            <span>Last name</span>
            <span class="relative mt-1.5 flex">
              <input class="form-input peer w-9/12 rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" type="text" id="last_name" name="last_name" maxlength="50" placeholder="Enter you last name" value="{{ old('last_name') }}">
              <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                <i class="far fa-user text-base"></i>
              </span>
            </span>
            @error('last_name')
            <span class="text-sm text-error">{{ $message }}</span>
            @enderror
          </label>

        </div>

        {{--BLOCK Email Address, Phone number (Honey pot)--}}
        <div class="grid grid-cols-1 gap-2 sm:grid-cols-2">

          {{-- Email Address --}}

          <label class="block">
            <span>Email Address</span>
            <div class="relative mt-1.5 flex">
              <input class="form-input peer w-9/12 rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" type="text" id="email" name="email" maxlength="100" placeholder="Enter your email" value="{{ old('email') }}">
              <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                <i class="fa-regular fa-envelope text-base"></i>
              </span>
            </div>
            @error('email')
            <span class="text-sm text-error">{{ $message }}</span>
            @enderror
            @if(!$errors->has('email'))
            <span class="text-sm text-slate-400 dark:text-navy-300">example@example.com</span>
            @endif
          </label>

          {{-- Phone Number (honeypot field)--}}

          <label class="block bee-food">
            <span>Phone number</span>
            <span class="relative mt-1.5 flex">
              <input class="form-input peer w-9/12 rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" type="text" x-input-mask="{numericOnly: true, blocks: [0, 3, 3, 4], delimiters: ['(', ') ', '-']}" id="phone-number" name="phone_number" size="40" maxlength="50" placeholder="Enter your phone number" value="{{ old('phone_number') }}">
              <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                <i class="fa fa-phone"></i>
              </span>
            </span>
            @error('phone_number')
            <span class="text-sm text-error">{{ $message }}</span>
            @enderror
            @if(!$errors->has('phone_number'))
            <span class="text-sm text-slate-400 dark:text-navy-300">e.g 0630799081</span>
            @endif
          </label>

        </div>

        {{--Subject--}}

        <label class="block">
          <span>Subject</span>
          <span class="relative mt-1.5 flex">
            <input class="form-input peer w-6/12 rounded-full border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" type="text" id="subject" name="subject" maxlength="100" placeholder="Enter the subject of your message" value="{{ old('subject') }}">
            <span class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
              <i class="fa-regular fa-s text-base"></i>
            </span>
          </span>
          @error('subject')
          <span class="text-sm text-error">{{ $message }}</span>
          @enderror
        </label>

        <div class="grid grid-cols-1 gap-2 sm:grid-cols-1">

          {{--Message--}}

          <label class="block">
            <span>Message</span><br>
            <textarea class="form-textarea mt-1.5 w-6/12 rounded-lg border border-slate-300 bg-transparent p-2.5 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent" id="message" name="message" rows="10"  maxlength="10000" placeholder="Enter your message here. Be as detailed as possible.">{{ old('message') }}</textarea><br>
            @if (session('success'))
            <div class="text-sm text-success">
              {{ session('success') }}
            </div>
            @else
            @error('message')
            <span class="text-sm text-error">{{ $message }}</span>
            @enderror
            @endif
          </label>

          <label class="block">

            {{--Recaptcha checkbox--}}
            <div class="g-recaptcha recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
            @error('g-recaptcha-response')
            <span class="text-sm text-error">{{ $message }}</span>
            @enderror
          </label>

          {{--Buttons Div--}}

          <div class="flex justify-start">
          <button class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90" type="submit">
                   Submit
                  </button>
            
          </div>

        </div>

      </div>

    </form>

  </div>
</body>

</html>