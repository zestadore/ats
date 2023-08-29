<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateEmailSettings;

class EnvController extends Controller
{
    public function getSiteDetails()
    {
        $data =[
            'app_name' => env('APP_NAME',''),
            'footer_name'=>env('APP_FOOTER',''),
            'site_logo'=>env('SITE_LOGO',''),
        ];
        return view('saas.site_settings',['data'=>$data]);
    }

    public function updateSiteSettings(Request $request)
    {
        $request->validate([
			'site_name' => 'required',
            'site_footer'=>'required',
            'logo'=>'nullable|mimes:jpeg,jpg,png|max:2048',
		]);
        $logo=env('SITE_LOGO','');
        if($request->file('logo')){
            if($logo!=null or $logo!=''){
                unlink(public_path('uploads/site_logo/'. $logo));
            }
            $file= $request->file('logo');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/site_logo'), $filename);
            $logo= $filename;
        }
        $env_update = $this->updateEnv([
            'APP_NAME'   => '"'.$request->site_name.'"',
            'APP_FOOTER'   => '"'.$request->site_footer.'"',
            'SITE_LOGO'       => '"'.$logo.'"'
        ]);
        if($env_update){
            return redirect()->back()->with('success', 'Successfully updated the data.');
        } else {
            return redirect()->back()->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function getMailDetails()
    {
        $data =[
            'mail_type' => env('MAIL_MAILER',''),
            'mail_host'=>env('MAIL_HOST',''),
            'mail_port'=>env('MAIL_PORT',''),
            'mail_username'=>env('MAIL_USERNAME',''),
            'mail_password'=>env('MAIL_PASSWORD',''),
            'mail_encryption'=>env('MAIL_ENCRYPTION','')
        ];
        return view('saas.mail_settings',['data'=>$data]);
    }

    public function updateMailSettings(ValidateEmailSettings $request)
    {
        $env_update = $this->updateEnv([
            'MAIL_MAILER'=> $request->mail_type,
            'MAIL_HOST'=> $request->mail_host,
            'MAIL_PORT'=> $request->mail_host,
            'MAIL_USERNAME'=> $request->mail_username,
            'MAIL_PASSWORD'=> $request->mail_password,
            'MAIL_ENCRYPTION'=> $request->mail_encryption
        ]);
        if($env_update){
            return redirect()->back()->with('success', 'Successfully updated the data.');
        } else {
            return redirect()->back()->with('error', 'Failed to update the data. Please try again.');
        }
    }

    private function updateEnv($data = array())
    {
        if(count($data) > 0){
            $pattern = '/([^\=]*)\=[^\n]*/';
            $envFile = base_path() . '/.env';
            $lines = file($envFile);
            $newLines = [];
            foreach ($lines as $line) {
                preg_match($pattern, $line, $matches);

                if (!count($matches)) {
                    $newLines[] = $line;
                    continue;
                }

                if (!key_exists(trim($matches[1]), $data)) {
                    $newLines[] = $line;
                    continue;
                }

                $line = trim($matches[1]) . "={$data[trim($matches[1])]}\n";
                $newLines[] = $line;
            }

            $newContent = implode('', $newLines);
            file_put_contents($envFile, $newContent);
            return true;
        }else{
            return false;
        }
        
    }
}
