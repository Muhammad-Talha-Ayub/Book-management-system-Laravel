<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use App\Helpers\RSAHelper; 

class Author extends Model
{
    protected $table = 'author';
    protected $guarded = [ 'id' ,'created_at' ,'updated_at'];
    protected $encryptFields = ['title', 'designation', 'phone', 'description'];

  public function author_books()
  {
  	return $this->hasMany(Book::class, 'author_id');
  }
  // public function setEncryptedFields()
    // {
    //     $publicKeyPath = storage_path('private_keys/public.pem');
    //     $publicKey = file_get_contents($publicKeyPath);

    //     $this->title = RSAHelper::encryptData($this->title, $publicKey);
    //     $this->designation = RSAHelper::encryptData($this->designation, $publicKey);
    //     $this->phone = RSAHelper::encryptData($this->phone, $publicKey);
    //     $this->description = RSAHelper::encryptData($this->description, $publicKey);
    // }

    // public function save(array $options = [])
    // {
    //     $this->setEncryptedFields();
    //     parent::save($options);
    // }

    // public function getDecryptedAttributesAttribute() 
    // {
    //     $privateKeyPath = storage_path('private_keys/private.pem');
    //     $privateKey = file_get_contents($privateKeyPath);

    //      $decryptedTitle = RSAHelper::decryptData($this->attributes['title'], $privateKey);
    //      $decryptedDesignation = RSAHelper::decryptData($this->attributes['designation'], $privateKey);
    //      $decryptedPhone = RSAHelper::decryptData($this->attributes['phone'], $privateKey);
    //      $decryptedDescription = RSAHelper::decryptData($this->attributes['description'], $privateKey);

    // return [
    //     'title' => $decryptedTitle,
    //     'designation' => $decryptedDesignation,
    //     'phone' => $decryptedPhone,
    //     'description' => $decryptedDescription,
    // ];

    // }

}

 // protected $fillable =['title' , 'slug' ,'designation' ,'dob'];
    //  if we are making big website then there is an alternative to it
    //                   protected $guarded = [ 'id', 'created_at', 'updated_at' ];
    //                   means every other file can be used to update ,delete etc except file mentioned in guarded  