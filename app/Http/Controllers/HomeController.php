<?php

namespace App\Http\Controllers;

use App\Models\Apropo;
use App\Models\Faq;
use App\Models\Favori;
use App\Models\Historiquepaiement;
use App\Models\Pack;
use App\Models\Parametre;
use App\Models\Partenaire;
use App\Models\PieceJointe;
use App\Models\Slider;
use App\Models\Statistique;
use App\Models\Types_statistique;
use App\Models\User;
use Ibracilinks\OrangeMoney\OrangeMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if ((Auth::user()->actif==0)and(Auth::user()->userType=="Administrateur")) {

          return view('backend/home');

        }elseif ((Auth::user()->actif==0)and(Auth::user()->userType=="simpleUser")) {

            $favoris=DB::table('favoris')
        ->where('id_user',Auth::user()->id)
        ->orderBy('id', 'DESC')
        ->get();

            return view('pages/home_public',compact('favoris'));
        }
    }


    public function gest_page()
    {
        
        return view('backend/gest_page');
    }

    public function getSlider(){

       return Slider::where('id', 1)->get();

    }

     public function upload(Request $request){

        $this->validate($request,[
            'file'=>'required|mimes:jpg,png,jpeg',
        ]);

        $fileName=time().'-'.$request->file->getClientOriginalName();

        $request->file->move(public_path('images'),$fileName);

        return $fileName;       

    }

     public function uploadFichier(Request $request){

        

        $fileName=time().'-'.$request->file->getClientOriginalName();

        $request->file->move(public_path('piece-jointe'),$fileName);

        return $fileName;       

    }


     public function editSlider(Request $request){

       $this->validate($request,[
            'titre'=>'required',
            'image'=>'required',
        ]);


       $slider1=Slider::where('id', $request->id)->update(['titre'=>$request->titre,'description'=>$request->description, 'image'=>$request->image,'afficherRechBar'=>$request->afficherRechBar]);

       return  $slider1;

    }


    public function getPropos(){

       return Apropo::where('id', 1)->get();

    }

     public function editPropos(Request $request){

       $this->validate($request,[
            'titre'=>'required',
            'description'=>'required',
        ]);


       $propo1=Apropo::where('id', $request->id)->update(['titre'=>$request->titre,'description'=>$request->description,'afficher'=>$request->afficher]);

       return  $propo1;

    }

     public function getPartenaire(){

       return Partenaire::where('supprimer', 0)->get();

    }

    public function addPartenaire(Request $request){

       $this->validate($request,[
            'nom'=>'required',
            'image'=>'required',
        ]);


    $partenaire=Partenaire::create(['nom'=>$request->nom,'image'=>$request->image]);

        

        return  $partenaire;

    }

     public function deletePartenaire(Request $request){

       $partenaire1=Partenaire::where('id', $request->id)->update(['supprimer'=>1]);

       return  $partenaire1;

    }


    public function getFaq(){

       return Faq::where('supprimer', 0)->get();

    }

    public function addFaq(Request $request){

       $this->validate($request,[
            'titre'=>'required',
            'description'=>'required',
        ]);


$faq=Faq::create(['titre'=>$request->titre,'description'=>$request->description]);

        

        return  $faq;

    }

     public function deleteFaq(Request $request){

       $faq1=Faq::where('id', $request->id)->update(['supprimer'=>1]);

       return  $faq1;

    }


     public function getContact(){

       return Parametre::where('id', 1)->get();

    }

     public function editContact(Request $request){

       $this->validate($request,[
            'email'=>'required',
            'tel1'=>'required',
            'tel2'=>'required',
            'adresse'=>'required',
        ]);


       $contact1=Parametre::where('id', $request->id)->update(['email'=>$request->email,'tel1'=>$request->tel1,'tel2'=>$request->tel2,'apropos'=>$request->apropos,'adresse'=>$request->adresse,'lien'=>$request->lien,'facebook'=>$request->facebook,'twitter'=>$request->twitter,'youtube'=>$request->youtube,'linkedin'=>$request->linkedin]);

       return  $contact1;

    }



    //User
       public function utilisateurs(){

      

       return  view('backend/utilisateurs');

    }

     public function getUtilisateurs(){

       return User::where('supprimer', 0)->get();

    }

     public function AddUser(Request $request){

        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
        ]);

        $defaultPassword=Hash::make('csmcadmin2021');


        $user=User::create(['name'=>$request->name,'email'=>$request->email,'userType'=>$request->userType, 'password'=>$defaultPassword,'session'=>date("Y")]);

        

        return  $user;

    }


     public function editUtilisateur(Request $request){

       $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
        ]);

       
       
         $user1=User::where('id', $request->id)->update(['name'=>$request->name,'email'=>$request->email,'userType'=>$request->userType]);


       

        return  $user1;

    }

    public function editActifUser(Request $request){

       $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'confirm'=>'required',
        ]);

       
       
         if ($request->password==$request->confirm) {

             $user1=User::where('id', $request->id)->update(['name'=>$request->name,'email'=>$request->email, 'password'=>Hash::make($request->password)]);
         }


       

        return  $user1;

    }

     public function deleteUser(Request $request){

             $user1=User::where('id', $request->id)
             ->update(['supprimer'=>1]);
             
               return  $user1;

    }

    public function profil(){

      

       return  view('backend/profil');

    }

    public function getActifUser(){
        
        return DB::table('users')
        ->where([['supprimer',0],['id',Auth::id()]])
        ->orderBy('id', 'DESC')
        ->get();

    }


    // TYPE STAT
     public function adminTypeStatistyque()
    {
        
        return view('backend/adminTypeStatistyque');
    }

    public function allTypeStat(){
        
        return DB::table('types_statistiques')
        ->where('supprimer',0)
        ->orderBy('id', 'DESC')
        ->get();

    }

     public function AddTypeStat(Request $request){

       $this->validate($request,[
            'libelle'=>'required',
            'image'=>'required',
        ]);


    $type=Types_statistique::create(['libelle'=>$request->libelle,'image'=>$request->image,'description'=>$request->description]);

        

        return  $type;

    }

     public function editTypeStat(Request $request){

       $this->validate($request,[
            'libelle'=>'required',
            'image'=>'required',
        ]);


       $type1=Types_statistique::where('id', $request->id)->update(['libelle'=>$request->libelle,'description'=>$request->description, 'image'=>$request->image]);

       return  $type1;

    }

     public function deleteType(Request $request){

       $type1=Types_statistique::where('id', $request->id)->update(['supprimer'=>1]);

       return  $type1;

    }

    // STATS

     public function adminStats()
    {
        
        return view('backend/adminStat');
    }

    public function allStat(){
        
        return DB::table('statistiques')
        ->join('types_statistiques', 'types_statistiques.id', '=', 'statistiques.id_type') 
        ->join('packs', 'packs.id', '=', 'statistiques.id_pack') 
        ->select('statistiques.*','types_statistiques.libelle as type','packs.nom as pack')
        ->where('statistiques.supprimer',0)
        ->orderBy('id', 'DESC')
        ->get();

    }

     public function AddStat(Request $request){

       $this->validate($request,[
            'libelle'=>'required',
            'id_type'=>'required',
        ]);


    $stat1=Statistique::create(['libelle'=>$request->libelle,'description'=>$request->description,'id_type'=>$request->id_type,'source'=>$request->source,'datePublication'=>$request->datePublication,'periode'=>$request->periode]);

        

        return  $stat1;

    }

     public function editStat(Request $request){

       $this->validate($request,[
            'libelle'=>'required',
            'id_type'=>'required',
        ]);


       $stat1=Statistique::where('id', $request->id)->update(['libelle'=>$request->libelle,'description'=>$request->description,'id_type'=>$request->id_type,'source'=>$request->source,'datePublication'=>$request->datePublication,'periode'=>$request->periode]);

       return  $stat1;

    }

     public function deleteStat(Request $request){

       $stat1=Statistique::where('id', $request->id)->update(['supprimer'=>1]);

       return  $stat1;

    }

     public function affliStat(Request $request){

      

       $stat1=Statistique::where('id', $request->id)->update(['id_pack'=>$request->id_pack]);

       return  $stat1;

    }

    // FAVORIS

     public function addFavoris(Request $request){

       $this->validate($request,[
            'idStat'=>'required',
        ]);

     $favoris1=Favori::create(['id_stat'=>$request->idStat,'id_user'=>Auth::user()->id]);

     return  $favoris1;

    }


    public function removeFavoris(Request $request){

       $this->validate($request,[
            'idStat'=>'required',
        ]);

     return Favori::where([['id_stat', $request->idStat],['id_user', Auth::user()->id]])->delete();

    }

    public function getFavoris($id){
        
        return DB::table('favoris')
        ->where([['id_stat',$id],['id_user',Auth::user()->id]])
        ->orderBy('id', 'DESC')
        ->get();

    }



     // PACKS

     public function adminPacks()
    {
        
        return view('backend/adminPack');
    }

    public function allPack(){
        
        return DB::table('packs')
        ->where('supprimer',0)
        ->orderBy('id', 'DESC')
        ->get();

    }

     public function AddPack(Request $request){

       $this->validate($request,[
            'nom'=>'required',
            'prix'=>'required',
        ]);


    $pack1=Pack::create(['nom'=>$request->nom,'description'=>$request->description,'prix'=>$request->prix,'duree'=>$request->duree]);

        

        return  $pack1;

    }

     public function editPack(Request $request){

       $this->validate($request,[
            'nom'=>'required',
            'prix'=>'required',
        ]);


       $pack1=Pack::where('id', $request->id)->update(['nom'=>$request->nom,'description'=>$request->description,'prix'=>$request->prix,'duree'=>$request->duree]);

       return  $pack1;

    }

     public function deletePack(Request $request){

       $pack1=Pack::where('id', $request->id)->update(['supprimer'=>1]);

       return  $pack1;

    }

    public function changePack()
    {
        $pack=DB::table('packs')
        ->where('supprimer',0)
        ->get();
        
        return view('pages/changePack',compact('pack'));
    }

     public function choixChangerPack($id)
    {
        $pack=DB::table('packs')
        ->where('id',$id)
        ->get();
        
        return view('pages/choixChangePack',compact('pack'));
    }

    // Payement

     public function typePayement(Request $request)
    {
        $prix=$request->prix;
        $id_pack=$request->id_pack;

        if ($request->typePayement=='OM') {
            return view('pages/typePayementOM',compact('prix','id_pack'));
        }else {
            
        }
        
        
        
    }

     public function lancerPayementOM(Request $request)
    {
        $prix=$request->prix;
        $id_pack=$request->id_pack;
        $val=0;
      $vals=DB::table('historiquepaiements')->get();
      foreach ( $vals as  $value) {
        $val=$value->id;
      }
      $val+=1;
      $order="FAC_ANANLITYCS".$val;


$payment = new OrangeMoney();

$data = [
    "merchant_key"=> '57f510e6',
    "currency"=> "OUV",
    "order_id"=> $order,
    "amount" => $prix,
"return_url"=> 'https://apip.gov.gn/retourPayement/'.$id_pack.'/'.$order.'/'.$prix,
    "cancel_url"=> 'https://apip.gov.gn/',
    "notif_url"=>'https://apip.gov.gn/',
    "lang"=> "fr"
];

$rep=$payment->webPayment($data);


$statu=$payment->checkTransactionStatus($order,$prix,$rep['pay_token']);

 $iduser= Auth::user()->id;
 $typeP="Orange-Money";
Historiquepaiement::create(['user_id'=>$iduser, 'orderId'=>$order,'amount'=>$request->montant,'payToken'=>$rep['pay_token'],'status'=>$statu['status'],'pack_id'=>$request->pack,'txnid'=>$statu['txnid'],'type_paiement'=>$typeP]);
  
       
        return redirect($rep['payment_url']);
        
        
    }

 public function retourPayement($id_pack, $order, $prix)
    {
        $prix=$prix;
        $id_pack=$id_pack;
        $order=$order;

        $paytoken='';
      $historique=DB::table('historiquepaiements')->where('orderId',$order)->get();
      foreach ( $historique as  $value) {
        $paytoken=$value->payToken;
      }


$payment = new OrangeMoney();


$statu=$payment->checkTransactionStatus($order,$prix,$paytoken);

 $iduser= Auth::user()->id;
 
  $historique1=Historiquepaiement::where('orderId', $order)->update(['status'=>$statu['status']]);

  if ($statu['status']=="SUCCESS") {
     
     session()->flash('message','Votre pack a été changé avec succès');
     $user1=User::where('id', Auth::user()->id)->update(['id_pack'=>$id_pack]);

  }else{
      session()->flash('message','Erreur!! Changement pack impossible');
  }

       $pack=DB::table('packs')
        ->where('supprimer',0)
        ->get();
        
        return view('pages/changePack',compact('pack'));
        
        
    }

    // Etats

    public function etat()
    {
        $pack=DB::table('packs')
        ->where('supprimer',0)
        ->get();
        
        return view('backend/etat',compact('pack'));
    }

    // Pièce Jointe

     public function adminPiece()
    {
        
        return view('backend/adminPiece');
    }

    public function allPiece(){
        
        return DB::table('piece_jointes')
        ->join('statistiques', 'statistiques.id', '=', 'piece_jointes.id_stat') 
        ->select('piece_jointes.*','statistiques.libelle as stat')
        ->where('piece_jointes.supprimer',0)
        ->orderBy('id', 'DESC')
        ->get();

    }

     public function AddPiece(Request $request){

       $this->validate($request,[
            'nom'=>'required',
            'id_stat'=>'required',
            'fichier'=>'required',
        ]);


    return PieceJointe::create(['nom'=>$request->nom,'id_stat'=>$request->id_stat,'fichier'=>$request->fichier]);

    }


     public function deletePiece(Request $request){

       $piece1=PieceJointe::where('id', $request->id)->update(['supprimer'=>1]);

       return  $piece1;

    }


}
