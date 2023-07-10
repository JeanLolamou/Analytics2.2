<?php 
use Illuminate\Support\Facades\DB;

if (! function_exists('active_route')) {
	function active_route($route){

		return Route::is($route) ? 'active' : '';


	}
}


if (! function_exists('getParametre')) {
    function getParametre(){

         $parametre =DB::table('parametres')
        ->where('id',1)
        ->get();

        return $parametre;

    }
}

if (! function_exists('getTypeStat')) {
    function getTypeStat(){

         $type =DB::table('types_statistiques')
        ->where('supprimer',0)
        ->orderBy('ordre')
        ->get();

        return $type;

    }
}

if (! function_exists('getNomType')) {
    function getNomType($id){
        $nom="";
         $type =DB::table('types_statistiques')
        ->where('id',$id)
        ->get();
        foreach ($type as $types) {
            $nom=$types->libelle;
        }

        return $nom;

    }
}


if (! function_exists('getInfoSlider')) {
    function getInfoSlider(){
    
         return DB::table('sliders')
        ->where('id',1)
        ->get();

         

    }
}

if (! function_exists('getInfoPropos')) {
    function getInfoPropos(){
    
         return DB::table('apropos')
        ->where('id',1)
        ->get();

         

    }
}

if (! function_exists('getInfoPartenaire')) {
    function getInfoPartenaire(){
    
         return DB::table('partenaires')
        ->where('supprimer',0)
        ->get();

         

    }
}

if (! function_exists('getInfoFaq')) {
    function getInfoFaq(){
    
         return DB::table('faqs')
        ->where('supprimer',0)
        ->get();

         

    }
}


if (! function_exists('getPieceJointe')) {
    function getPieceJointe($id){

         $piece =DB::table('piece_jointes')
        ->where([['id_stat',$id],['supprimer',0]])
        ->orderBy('id')
        ->get();

        return $piece;

    }
}

if (! function_exists('getNomPack')) {
    function getNomPack($id){
         $nom="";
         $pack =DB::table('packs')
        ->where('id',$id)
        ->get();

         foreach ($pack as $pack) {
            $nom=$pack->nom;
         }
         
        return $nom;

    }
}

if (! function_exists('estdanslepack')) {
    function estdanslepack($id){
         $rep=false; $id_pack=1;

         $stat =DB::table('statistiques')
        ->where('id',$id)
        ->get();

         foreach ($stat as $stat) {
            $id_pack=$stat->id_pack;
         }

         if ($id_pack==1) {
             $rep=true;
         }elseif (Auth::user()->id_pack==$id_pack) {
             $rep=true;
         }elseif (Auth::user()->id_pack==3) {
             $rep=true;
         }
         
        return $rep;

    }
}


if (! function_exists('getNomStat')) {
    function getNomStat($id){
         $nom="";
         $stat =DB::table('statistiques')
        ->where('id',$id)
        ->get();

         foreach ($stat as $stat) {
            $nom=$stat->libelle;
         }
         
        return $nom;

    }
}

if (! function_exists('getNombreUser')) {
    function getNombreUser($type){
         $nbre=0;
         if ($type=='h') {
             $user =DB::table('users')
        ->where([['userType','simpleUser'],['sexe','homme'],['supprimer',0]])
        ->get();
         }elseif ($type=='f') {
              $user =DB::table('users')
        ->where([['userType','simpleUser'],['sexe','femme'],['supprimer',0]])
        ->get();
         }elseif ($type=='all') {
              $user =DB::table('users')
        ->where([['userType','simpleUser'],['supprimer',0]])
        ->get();
         }
         

         $nbre=$user->count();
         
        return $nbre;

    }
}

if (! function_exists('getNombreInscri')) {
    function getNombreInscri($type){
         $nbre=0;
         if ($type=='OM') {
             $user =DB::table('historiquepaiements')
        ->where([['type_paiement','Orange-Money'],['status','SUCCESS']])
        ->get();
         $nbre=$user->count();
         }elseif ($type=='MOMO') {
              $user =DB::table('historiquepaiements')
        ->where([['type_paiement','Mobile-Money'],['status','SUCCESS']])
        ->get();
         $nbre=$user->count();
         }elseif ($type=='paycard') {
               $user =DB::table('historiquepaiements')
        ->where([['type_paiement','Paycard'],['status','SUCCESS']])
        ->get();
         $nbre=$user->count();
         }elseif ($type=='paypal') {
               $user =DB::table('historiquepaiements')
        ->where([['type_paiement','Paypal'],['status','SUCCESS']])
        ->get();
         $nbre=$user->count();
         }elseif ($type=='visa') {
               $user =DB::table('historiquepaiements')
        ->where([['type_paiement','Paypal'],['status','SUCCESS']])
        ->get();
         $nbre=$user->count();
         }
         

        
         
        return $nbre;

    }
}

if (! function_exists('getSommeInscri')) {
    function getSommeInscri($type){
         $somme=0;
         if ($type=='OM') {
             $user =DB::table('historiquepaiements')
        ->where([['type_paiement','Orange-Money'],['status','SUCCESS']])
        ->get();
         }elseif ($type=='MOMO') {
              $user =DB::table('historiquepaiements')
        ->where([['type_paiement','Mobile-Money'],['status','SUCCESS']])
        ->get();
         }elseif ($type=='paycard') {
               $user =DB::table('historiquepaiements')
        ->where([['type_paiement','Paycard'],['status','SUCCESS']])
        ->get();
         }elseif ($type=='paypal') {
               $user =DB::table('historiquepaiements')
        ->where([['type_paiement','Paypal'],['status','SUCCESS']])
        ->get();
         }elseif ($type=='visa') {
               $user =DB::table('historiquepaiements')
        ->where([['type_paiement','Paypal'],['status','SUCCESS']])
        ->get();
         }elseif ($type=='all') {
               $user =DB::table('historiquepaiements')
        ->where('status','SUCCESS')
        ->get();
         }

         foreach ($user as $users) {
            $somme+=$users->amount;
         }
         
         
        return $somme;

    }
}

if (! function_exists('getNombreInscriPack')) {
    function getNombreInscriPack($id){
         $nbre=0;
         $pack =DB::table('users')
        ->where([['id_pack',$id],['userType','simpleUser'],['supprimer',0]])
        ->get();
         

         $nbre=$pack->count();
         
        return $nbre;

    }
}

// Ancien Site

if (! function_exists('active_menu')) {
    function active_menu($menu,$pack){

        $menu =DB::table('packmenus')     
        ->where([['id_menu','=', $menu],['id_pack','=', $pack]])
        ->get();

        $etat=0;
        foreach ($menu as $menu) {
            $etat=$menu->etat;
        }

        if ($etat==0) {
            return 'display:none';
        }else{
             return '';
        }

    }
}


if (! function_exists('etat_menu')) {
    function etat_menu($menu,$pack){
        
         $menu =DB::table('packmenus')     
        ->where([['id_menu','=', $menu],['id_pack','=', $pack]])
        ->get();

        $etat=0;
        foreach ($menu as $menu) {
            $etat=$menu->etat;
        }

        return $etat;


    }
}

 // Production Mine

    if (! function_exists('production_mine')) {
    function production_mine($annee,$produit,$region){
         $nombre =DB::table('production_mines')
        ->where([['annee','=',$annee],['id_mine','=',$produit],['id_region','=',$region]])
        ->get();
        $production=0;
        foreach ($nombre as $nombre) {
            $production=$nombre->valeur;
        }
        return $production;

    }
}

if (! function_exists('secteur_activite')) {
    function secteur_activite($secteur,$debut,$fin){
        
         $total =DB::table('dossierdemandes')
        ->join('secteuractivite', 'secteuractivite.id', '=', 'dossierdemandes.idSecteurActivite')
      ->join('categorieactivite', 'categorieactivite.id', '=', 'secteuractivite.idCategorieActivite')
        ->select('categorieactivite.*', 'dossierdemandes.*')        
        ->where('categorieactivite.id','=', $secteur)
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();

        return $total;


    }
}

if (! function_exists('region_compte')) {
    function region_compte($region,$debut,$fin){
        
         $nombre =DB::table('region')
        ->join('dossierdemandes', 'dossierdemandes.idRegion', '=', 'region.id') 
        ->select('dossierdemandes.*', 'region.libelle')
        ->where('region.id','=', $region)
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();

        return $nombre;

    }
}


if (! function_exists('secteur_juridique')) {
    function secteur_juridique($statut,$secteur,$debut,$fin){
        
         $total =DB::table('formejuridique')
         ->join('dossierdemandes', 'dossierdemandes.idFormeJuridique', '=', 'formejuridique.id') 
        ->join('secteuractivite', 'secteuractivite.id', '=', 'dossierdemandes.idSecteurActivite')
      ->join('categorieactivite', 'categorieactivite.id', '=', 'secteuractivite.idCategorieActivite')
        ->select('categorieactivite.*', 'formejuridique.*')        
        ->where('categorieactivite.id','=', $secteur)
        ->where('formejuridique.id','=', $statut)
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();

        return $total;


    }
}


if (! function_exists('forme_compte')) {
    function forme_compte($statut,$debut,$fin){
        
         $nombre =DB::table('formejuridique')
        ->join('dossierdemandes', 'dossierdemandes.idFormeJuridique', '=', 'formejuridique.id') 
        ->select('dossierdemandes.*', 'formejuridique.sigle')
        ->where('formejuridique.id','=', $statut)
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();

        return $nombre;

    }
}

if (! function_exists('genre_compte')) {
    function genre_compte($sexe,$debut,$fin){
        
         $nombre =DB::table('representant')
        ->join('dossierdemandes', 'dossierdemandes.id', '=', 'representant.idDossierDemande') 
        ->select('dossierdemandes.*', 'representant.*')
        ->where('representant.idGenre','=', $sexe)
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();

        return $nombre;

    }
}


if (! function_exists('duree_rccm_compte')) {
    function duree_rccm_compte($duree,$debut,$fin){
       
        if ($duree==24) {
            $total =DB::table('dossierdemandes')
        ->join('rccm', 'rccm.idDossierDemande', '=', 'dossierdemandes.id')
        ->whereRaw('DATEDIFF(rccm.date,dossierdemandes.dateCreation)=0')
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();
        }elseif ($duree==48) {
            $total =DB::table('dossierdemandes')
        ->join('rccm', 'rccm.idDossierDemande', '=', 'dossierdemandes.id')
        ->whereRaw('DATEDIFF(rccm.date,dossierdemandes.dateCreation)=1')
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();
        }elseif ($duree==72) {
            $total =DB::table('dossierdemandes')
        ->join('rccm', 'rccm.idDossierDemande', '=', 'dossierdemandes.id')
        ->whereRaw('DATEDIFF(rccm.date,dossierdemandes.dateCreation)=2')
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();
        }elseif ($duree==96){

            $total =DB::table('dossierdemandes')
        ->join('rccm', 'rccm.idDossierDemande', '=', 'dossierdemandes.id')
        ->whereRaw('DATEDIFF(rccm.date,dossierdemandes.dateCreation)=3')
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();

        }

        return $total;

    }
}



if (! function_exists('duree_nif_compte')) {
    function duree_nif_compte($duree,$debut,$fin){
       
        if ($duree==24) {
            $total =DB::table('dossierdemandes')
        ->join('nif', 'nif.idDossierDemande', '=', 'dossierdemandes.id')
        ->whereRaw('DATEDIFF(nif.date,dossierdemandes.dateCreation)=0')
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();
        }elseif ($duree==48) {
            $total =DB::table('dossierdemandes')
        ->join('nif', 'nif.idDossierDemande', '=', 'dossierdemandes.id')
        ->whereRaw('DATEDIFF(nif.date,dossierdemandes.dateCreation)=1')
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();
        }elseif ($duree==72) {
            $total =DB::table('dossierdemandes')
        ->join('nif', 'nif.idDossierDemande', '=', 'dossierdemandes.id')
        ->whereRaw('DATEDIFF(nif.date,dossierdemandes.dateCreation)=2')
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();
        }elseif ($duree==96){

            $total =DB::table('dossierdemandes')
        ->join('nif', 'nif.idDossierDemande', '=', 'dossierdemandes.id')
        ->whereRaw('DATEDIFF(nif.date,dossierdemandes.dateCreation)=3')
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();

        }

        return $total;

    }
}


if (! function_exists('age_compte')) {
    function age_compte($age,$debut,$fin){
        if ($age==1) {
            $today=date("Y-m-d");
        $annee1=date('Y-m-d', strtotime("-30 years"));
             $nombre =DB::table('representant')
        ->join('dossierdemandes', 'dossierdemandes.id', '=', 'representant.idDossierDemande') 
        ->select('dossierdemandes.*', 'representant.*')
        ->whereBetween('representant.dateDeNaissance', [$annee1,$today])
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();

        }elseif ($age==2) {
            $annee1=date('Y-m-d', strtotime("-30 years"));
        $annee2=date('Y-m-d', strtotime("-40 years"));
             $nombre =DB::table('representant')
        ->join('dossierdemandes', 'dossierdemandes.id', '=', 'representant.idDossierDemande')   
        ->select('dossierdemandes.*', 'representant.*')
        ->whereBetween('representant.dateDeNaissance', [$annee2,$annee1])
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();
        }elseif ($age==3) {
            $annee1=date('Y-m-d', strtotime("-40 years"));
        $annee2=date('Y-m-d', strtotime("-50 years"));
             $nombre =DB::table('representant')
        ->join('dossierdemandes', 'dossierdemandes.id', '=', 'representant.idDossierDemande')   
        ->select('dossierdemandes.*', 'representant.*')
        ->whereBetween('representant.dateDeNaissance', [$annee2,$annee1])
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();
        }elseif ($age==4) {
            $annee1=date('Y-m-d', strtotime("-50 years"));
        $annee2=date('Y-m-d', strtotime("-60 years"));
             $nombre =DB::table('representant')
        ->join('dossierdemandes', 'dossierdemandes.id', '=', 'representant.idDossierDemande')   
        ->select('dossierdemandes.*', 'representant.*')
        ->whereBetween('representant.dateDeNaissance', [$annee2,$annee1])
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();
        }
        else {
            $annee1=date('Y-m-d', strtotime("-60 years"));
        $annee2=date('Y-m-d', strtotime("-100 years"));
             $nombre =DB::table('representant')
        ->join('dossierdemandes', 'dossierdemandes.id', '=', 'representant.idDossierDemande')   
        ->select('dossierdemandes.*', 'representant.*')
        ->whereBetween('representant.dateDeNaissance', [$annee2,$annee1])
        ->whereBetween('dossierdemandes.dateCreation', [$debut,$fin])
        ->get();
        }
        return $nombre;

    }
}


if (! function_exists('crea_compte')) {
    function crea_compte($year){
        $nombre =DB::table('dossierdemandes')
        ->whereYear('dateCreation','=', $year)
        ->get();

        return $nombre;
        }
    }


    // Production

    if (! function_exists('production')) {
    function production($annee,$produit,$region){
         $nombre =DB::table('productions')
        ->where([['annee','=',$annee],['id_culture','=',$produit],['id_region','=',$region]])
        ->get();
        $production=0;
        foreach ($nombre as $nombre) {
            $production=$nombre->production;
        }
        return $production;

    }
}


if (! function_exists('superficie')) {
    function superficie($annee,$produit,$region){
         $nombre =DB::table('productions')
        ->where([['annee','=',$annee],['id_culture','=',$produit],['id_region','=',$region]])
        ->get();
        $superficie=0;
        foreach ($nombre as $nombre) {
            $superficie=$nombre->superficie;
        }
        return $superficie;

    }
}

if (! function_exists('rendement')) {
    function rendement($annee,$produit,$region){
         $nombre =DB::table('productions')
        ->where([['annee','=',$annee],['id_culture','=',$produit],['id_region','=',$region]])
        ->get();
        $rendement=0;
        foreach ($nombre as $nombre) {
            if ($nombre->superficie!=0 AND $nombre->production) {
                $rendement=($nombre->production/$nombre->superficie);
            }
        }
        return $rendement;

    }
}


 if (! function_exists('prod_region')) {
    function prod_region($annee,$produit,$region){

         if ($produit==0) {
          $nombre =DB::table('productions')
        ->where([['annee','=',$annee],['id_region','=',$region]])
        ->get();
        }else{

          $nombre =DB::table('productions')
        ->where([['annee','=',$annee],['id_culture','=',$produit],['id_region','=',$region]])
        ->get();

        }
         
        $production=0;
        foreach ($nombre as $nombre) {
            $production=$nombre->production;
        }
        return $production;

    }
}

if (! function_exists('nom_pays')) {
    function nom_pays($id){
         $pays =DB::table('pays')
        ->where('id','=', $id)
        ->get();
        $nom="";
        foreach ($pays as $pays) {
            $nom=$pays->nom_fr_fr;
        }
        return $nom;

    }
}

if (! function_exists('nom_prod')) {
    function nom_prod($id){
         $produit =DB::table('produits')
        ->where('id','=', $id)
        ->get();
        $nom="";
        foreach ($produit as $produit) {
            $nom=$produit->produit_name;
        }
        return $nom;

    }
}


if (! function_exists('exportationpays')) {
    function exportationpays($annee,$produit,$pays){
        if ($pays==0) {
           $nombre =DB::table('exportations')
        ->where([['annee','=',$annee],['id_produit','=',$produit]])
        ->get();
        }else{

          $nombre =DB::table('exportations')
        ->where([['annee','=',$annee],['id_produit','=',$produit],['id_pays','=',$pays]])
        ->get();

        }
        $quantite=0;
        foreach ($nombre as $nombre) {
            $quantite+=$nombre->quantite;
        }
        return $quantite;

    }
}

if (! function_exists('exportation')) {
    function exportation($annee,$produit,$region){
         $nombre =DB::table('exportations')
        ->where([['annee','=',$annee],['id_produit','=',$produit]])
        ->get();
        $quantite=0;
        foreach ($nombre as $nombre) {
            $quantite+=$nombre->quantite;
        }
        return $quantite;

    }
}


if (! function_exists('importation')) {
    function importation($annee,$produit){
         $nombre =DB::table('importations')
        ->where([['annee','=',$annee],['id_culture','=',$produit]])
        ->get();
        $quantite=0;
        foreach ($nombre as $nombre) {
            $quantite+=$nombre->quantite;
        }
        return $quantite;

    }
}

if (! function_exists('importationpays')) {
    function importationpays($annee,$produit,$pays){
         if ($pays==0) {
            $nombre =DB::table('importations')
        ->where([['annee','=',$annee],['id_culture','=',$produit]])
        ->get();
         }else{
             $nombre =DB::table('importations')
        ->where([['annee','=',$annee],['id_culture','=',$produit],['id_pays','=',$pays]])
        ->get();
         }
        
        $quantite=0;
        foreach ($nombre as $nombre) {
            $quantite+=$nombre->quantite;
        }
        return $quantite;

    }
}

if (! function_exists('comparaisonexpo')) {
    function comparaisonexpo($annee,$pays,$produit){
        if ($produit==0) {
           $nombre =DB::table('exportations')
        ->where([['annee','=',$annee],['id_pays','=',$pays]])
        ->get();
        }else{

          $nombre =DB::table('exportations')
        ->where([['annee','=',$annee],['id_produit','=',$produit],['id_pays','=',$pays]])
        ->get();

        }
        $quantite=0;
        foreach ($nombre as $nombre) {
            $quantite+=$nombre->quantite;
        }
        return $quantite;

    }
}


if (! function_exists('comparaisonimpor')) {
    function comparaisonimpor($annee,$pays,$produit){
         if ($produit==0) {
            $nombre =DB::table('importations')
        ->where([['annee','=',$annee],['id_pays','=',$pays]])
        ->get();
         }else{
             $nombre =DB::table('importations')
        ->where([['annee','=',$annee],['id_culture','=',$produit],['id_pays','=',$pays]])
        ->get();
         }
        
        $quantite=0;
        foreach ($nombre as $nombre) {
            $quantite+=$nombre->quantite;
        }
        return $quantite;

    }
}

 ?>