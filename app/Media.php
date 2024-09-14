<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use App\Helpers\RSAHelper; 
class Media extends Model
{
       protected $table = 'media';
        //protected $fillable =['title' , 'slug' ,'media_img'];
     // if we are making big website then there is an alternative to it
                     //  protected $guarded = [ 'id', 'created_at', 'updated_at' ];
                     //  means every other file can be used to update ,delete etc except file mentioned in guarded 
                     protected $guarded = [ 'id' ,'created_at' ,'updated_at'];  
                     protected $encryptFields = ['title'];

// public function setEncryptedFields()
//     {
//         // Load the public key from the file
//         $publicKeyPath = storage_path('private_keys/public.pem');
//         $publicKey = file_get_contents($publicKeyPath);

//         // Encrypt fields before saving
//         $this->title = RSAHelper::encryptData($this->title, $publicKey);
//         // Add more fields as needed
//     }

//     // Override the save method to automatically set encrypted fields
//     public function save(array $options = [])
//     {
//         $this->setEncryptedFields();
//         parent::save($options);
//     }

//     // Other methods...

//     // Example method for decrypting data (adjust as needed)
//     public function getDecryptedAttributesAttribute() 
//     //getDecryptedTitleAttribute()
//     {
//         // Load the private key from the file
//         $privateKeyPath = storage_path('private_keys/private.pem');
//         $privateKey = file_get_contents($privateKeyPath);

//          $decryptedTitle = RSAHelper::decryptData($this->attributes['title'], $privateKey);

//     // Return the decrypted values as an associative array
//     return [
//         'title' => $decryptedTitle,
//     ];

//     }
}
