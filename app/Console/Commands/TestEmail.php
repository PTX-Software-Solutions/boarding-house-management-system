<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Exception;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email : The email address to send test email to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test email to verify email configuration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $this->info('Testing email configuration...');
        $this->info("Sending test email to: {$email}");
        
        try {
            Mail::raw('This is a test email from your Laravel application. Email configuration is working correctly!', function ($message) use ($email) {
                $message->to($email)
                    ->subject('Email Configuration Test - ' . config('app.name'));
            });
            
            $this->info('✅ Test email sent successfully!');
            $this->info('Email configuration is working properly.');
            
        } catch (Exception $e) {
            $this->error('❌ Failed to send test email!');
            $this->error('Error: ' . $e->getMessage());
            $this->newLine();
            $this->info('Please check your email configuration in the .env file:');
            $this->info('- MAIL_MAILER');
            $this->info('- MAIL_HOST');
            $this->info('- MAIL_PORT');
            $this->info('- MAIL_USERNAME');
            $this->info('- MAIL_PASSWORD');
            $this->info('- MAIL_ENCRYPTION');
            $this->info('- MAIL_FROM_ADDRESS');
            
            return Command::FAILURE;
        }
        
        return Command::SUCCESS;
    }
}
