<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Mail\SendMailBack;
use App\Models\Demandeuser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function index()
    { 

        return view('pages/index');
        
    } 

     public function confirm($id,$token)
    {
        $users = User::where('id',$id)->where('confirmation_token',$token)->first();
        
        if ($users) {
            $users->update(['confirmation_token'=>null]);
             Auth::login($users, true);
             session()->flash('success','Votre compte a bien été activé.');
           
                return redirect('/home');
                
        }else{
           session()->flash('error','Ce lien ne semble plus valide');
      return redirect('/login');
        }
    }

     public function TypeStat($id)
    { 
        $typeId=$id;

        $stats =DB::table('statistiques')
        ->where([['id_type',$id],['supprimer',0]])
        ->get();

        return view('pages/TypeStat',compact('typeId','stats'));
        
    } 

     public function allStatType($id){
        
        return DB::table('statistiques')
        ->where([['id_type',$id],['supprimer',0]])
        ->get();

    }

     public function ecriveznous(Request $request){
        $this->validate($request,[
              'message'=>'required'
            ]);

     $data=array(
           'nom'=>Auth::user()->name,
           'prenom'=>Auth::user()->prenom,
           'email'=>Auth::user()->email,
           'tel'=>Auth::user()->tel,
           'objet'=>$request->objet,
           'message'=>$request->message
          );

     
    
     Mail::to('aliou.diallo@apipguinee.com')->send(new SendMail($data));

     Mail::to(Auth::user()->email)->send(new SendMailBack($data));

      Demandeuser::create(['id_user'=>Auth::user()->id,'objet'=>$request->objet,'message'=>$request->message]);

     session()->flash('success','Demande envoyé, Veuillez vérifier votre courrier électronique pour obtenir plus de détails de votre demande.');  

      return back()->with('success','Demande envoyé, Veuillez vérifier votre courrier électronique pour obtenir plus de détails de votre demande.');
    
    }

     public function getRechercheStat(Request $request){
        
    return DB::table('statistiques')
       ->where([[DB::raw('lower(libelle)'), 'like', '%' . strtolower($request->q) . '%'],['id_type',$request->type],['supprimer',0]])
        ->get();
    }

     public function detailStat(Request $request,$id)
    { 
        $id=$id;
         if (isset($request->between)) {
           $debut=date($request->debut);
           $fin=date($request->fin);

        }elseif(isset($request->trimestre)){
             if ($request->trimestre=="trimestre1") {
                $annee=$request->annee;
                $debut=date($annee.'-01-01');
                $fin=date($annee.'-03-31');
             }elseif ($request->trimestre=="trimestre2") {
                $annee=$request->annee;
                $debut=date($annee.'-04-01');
                $fin=date($annee.'-06-30');
             }elseif ($request->trimestre=="trimestre3") {
                $annee=$request->annee;
                $debut=date($annee.'-07-01');
                $fin=date($annee.'-09-30');
             }elseif ($request->trimestre=="trimestre4") {
                $annee=$request->annee;
                $debut=date($annee.'-10-01');
                $fin=date($annee.'-12-31');
             }elseif ($request->trimestre=="semestre1") {
                $annee=$request->annee;
                $debut=date($annee.'-01-01');
                $fin=date($annee.'-06-30');
             }elseif ($request->trimestre=="semestre2") {
                $annee=$request->annee;
                $debut=date($annee.'-07-01');
                $fin=date($annee.'-12-31');
             }
        }else{
            $annee=date("Y")-2;
             $debut=date($annee.'-01-01');
           $fin=date($annee.'-12-31');
        }
            

        $region =DB::table('region')
        ->where([['actif','=', 1],['id','!=', 11]])
        ->get();

        $produit =DB::table('produits')
        ->where('actif','=', 1)
        ->get();

        $pay =DB::table('pays')->orderBy('nom_fr_fr')
        ->get();

        $secteur =DB::table('categorieactivite')
         ->join('categorieactivitetraduction', 'categorieactivitetraduction.idCategorieActivite', '=', 'categorieactivite.id')
        ->select('categorieactivite.*', 'categorieactivitetraduction.libelle')
        ->where('categorieactivitetraduction.idLangue','=', 1)
        ->get();

        $total =DB::table('dossierdemandes')->whereBetween('dateCreation', [$debut,$fin])
        ->get();

        $multiple_pays="";

         $formejuridique =DB::table('formejuridique')
        ->where('actif','=', 1)
        ->get();

         if (isset($request->produit)) {
             $default_prod=$request->produit;
             $tab=1;
         }else{
            $default_prod =0;
         }

          if (isset($request->pays)) {
             $default_pays=$request->pays;
             $tab=2;
         }elseif (isset($request->importpays)) {
             $default_pays=$request->importpays;
             $tab=3;
         }elseif (isset($request->multiplepays)) {

             $multiple_pays=$request->multiplepays;
             $tab=4;
             $default_pays=0;
         }elseif (isset($request->multiplepays2)) {

             $multiple_pays=$request->multiplepays2;
             $tab=5;
             $default_pays=0;
         }else{
            $default_pays=0;
         }


       if ($id==5) {
           return view('pages/detailsStatRegion',compact('region','secteur','debut','fin','total','formejuridique','id'));
       }elseif ($id==6) {
           return view('pages/detailsStatJuridique',compact('region','secteur','debut','fin','total','formejuridique','id'));
       }elseif ($id==7) {
           return view('pages/detailsStatGenre',compact('region','secteur','debut','fin','total','formejuridique','id'));
       }elseif ($id==8) {
           return view('pages/detailsStatDureeRccm',compact('region','secteur','debut','fin','total','formejuridique','id'));
       }elseif ($id==9) {
           return view('pages/detailsStatDureeNif',compact('region','secteur','debut','fin','total','formejuridique','id'));
       }elseif ($id==10) {
           return view('pages/detailsStatAge',compact('region','secteur','debut','fin','total','formejuridique','id'));
       }elseif ($id==11) {
           return view('pages/detailsStatCreationAnnuelle',compact('region','secteur','debut','fin','total','formejuridique','id'));
       }elseif ($id==12) {
           return view('pages/detailsStatSecteurActivite',compact('region','secteur','debut','fin','total','formejuridique','id'));
       }elseif ($id==13) {
           return view('pages/detailsStatProductionAgricole',compact('region','produit','default_prod','default_pays','pay','multiple_pays','id'));
       }elseif ($id==14) {
           return view('pages/detailsStatSuperficieProduction',compact('region','produit','default_prod','default_pays','pay','multiple_pays','id'));
       }elseif ($id==15) {
           return view('pages/detailsStatRendementProduction',compact('region','produit','default_prod','default_pays','pay','multiple_pays','id'));
       }elseif ($id==16) {
           return view('pages/detailsStatProductionRegion',compact('region','produit','default_prod','default_pays','pay','multiple_pays','id'));
       }
        
    } 


    public function detailStatAgricole(Request $request,$id)
    { 
        $tab=0;
        
          if (isset($request->between)) {
           $debut=date($request->debut);
           $fin=date($request->fin);
        }elseif(isset($request->trimestre)){
             if ($request->trimestre=="trimestre1") {
                $annee=$request->annee;
                $debut=date($annee.'-01-01');
                $fin=date($annee.'-03-31');
             }elseif ($request->trimestre=="trimestre2") {
                $annee=$request->annee;
                $debut=date($annee.'-04-01');
                $fin=date($annee.'-06-30');
             }elseif ($request->trimestre=="trimestre3") {
                $annee=$request->annee;
                $debut=date($annee.'-07-01');
                $fin=date($annee.'-09-30');
             }elseif ($request->trimestre=="trimestre4") {
                $annee=$request->annee;
                $debut=date($annee.'-10-01');
                $fin=date($annee.'-12-31');
             }elseif ($request->trimestre=="semestre1") {
                $annee=$request->annee;
                $debut=date($annee.'-01-01');
                $fin=date($annee.'-06-30');
             }elseif ($request->trimestre=="semestre2") {
                $annee=$request->annee;
                $debut=date($annee.'-07-01');
                $fin=date($annee.'-12-31');
             }
        }else{
            $annee=date("Y");
             $debut=date($annee.'-01-01');
           $fin=date($annee.'-12-31');
        }
            

        $region =DB::table('region')
        ->where([['actif','=', 1],['id','!=', 11]])
        ->get();

        $produit =DB::table('produits')
        ->where('actif','=', 1)
        ->get();

        $pay =DB::table('pays')->orderBy('nom_fr_fr')
        ->get();
        
        
         if (isset($request->produit)) {
             $default_prod=$request->produit;
             $tab=1;
         }else{
            $default_prod =0;
         }

          if (isset($request->pays)) {
             $default_pays=$request->pays;
             $tab=2;
         }elseif (isset($request->importpays)) {
             $default_pays=$request->importpays;
             $tab=3;
         }elseif (isset($request->multiplepays)) {

             $multiple_pays=$request->multiplepays;
             $tab=4;
             $default_pays=0;
         }elseif (isset($request->multiplepays2)) {

             $multiple_pays=$request->multiplepays2;
             $tab=5;
             $default_pays=0;
         }else{
            $default_pays=0;
         }


       if ($id==13) {
           return view('pages/detailsStatProductionAgricole',compact('region','produit','default_prod','tab','default_pays','pay','multiple_pays'));
       }elseif ($id==6) {
           return view('pages/detailsStatJuridique',compact('region','produit','default_prod','tab','default_pays','pay','multiple_pays'));
       }
        
    } 

     public function inscription($id)
    { 
        $typeId=$id;
        $pays =DB::table('pays')
        ->get();

        if ($typeId==1) {
             return view('auth/inscription_gratuite',compact('typeId','pays'));
        }else{
            return view('auth/inscription',compact('typeId','pays'));
        }
        
    } 
}
