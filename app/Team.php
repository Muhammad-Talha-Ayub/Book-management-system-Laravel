<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use App\Helpers\RSAHelper; 
class Team extends Model
{
        protected $table = 'team';
         //protected $fillable =['fullname' , 'designation' ,'team_img' ,'email' ,'facebook-id','twitter_id','pinterest_id'];
     // if we are making big website then there is an alternative to it
                     //  protected $guarded = [ 'id', 'created_at', 'updated_at' ];
                     //  means every other file can be used to update ,delete etc except file mentioned in guarded 
        protected $guarded = [ 'id' ,'created_at' ,'updated_at'];  
        protected $encryptFields = ['fullname', 'designation'];
        // public function setEncryptedFields()
        // {
        //     // Load the public key from the file
        //     $publicKeyPath = storage_path('private_keys/public.pem');
        //     $publicKey = file_get_contents($publicKeyPath);
    
        //     // Encrypt fields before saving
        //     $this->fullname = RSAHelper::encryptData($this->fullname, $publicKey);
        //     $this->designation = RSAHelper::encryptData($this->designation, $publicKey);
        //     // Add more fields as needed
        // }
    
        // // Override the save method to automatically set encrypted fields
        // public function save(array $options = [])
        // {
        //     $this->setEncryptedFields();
        //     parent::save($options);
        // }
    
        // // Other methods...
    
        // // Example method for decrypting data (adjust as needed)
        // public function getDecryptedAttributesAttribute() 
        // //getDecryptedTitleAttribute()
        // {
        //     // Load the private key from the file
        //     $privateKeyPath = storage_path('private_keys/private.pem');
        //     $privateKey = file_get_contents($privateKeyPath);
    
        //      $decryptedFullName = RSAHelper::decryptData($this->attributes['fullname'], $privateKey);
        // $decryptedDesignation = RSAHelper::decryptData($this->attributes['designation'], $privateKey);
    
        // // Return the decrypted values as an associative array
        // return [
        //     'fullname' => $decryptedFullName,
        //     'designation' => $decryptedDesignation,
        // ];
    
        // }
}
