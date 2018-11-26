<?php

namespace App\Http\Controllers;
     /**
    
     * declaration des dependance
     */
use App\Autre;
use App\Avocat;
use App\Convocation;
use App\Defendeur;
use App\Defendeurs_avocats;
use App\Dossier;
use App\Http\Requests\ConvocationRequest;
use App\Immobilier;
use App\Immobiliers_natures;
use App\Jugement;
use App\Jugements_autres;
use App\Jugements_defendeurs;
use App\Jugements_procureurs;
use App\Nature;
use App\Personnel;
use App\Procureur;
use App\Procureurs_avocats;
use App\Tribunal;
use App\Tribunals_villes;
use App\Tribunalsvilles;
use App\Villes;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\Shared\ZipArchive;
use PhpOffice\PhpWord\Exception\Exception;

class ConvocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     /**
    
     * @return l'interface de convocation page 1
     */
    public function index()
    {
        $personnel=Personnel::pluck('name','id_personnel');
        $tribunal=Tribunal::pluck('nom_tribunal','id_tribunal');
        $ville=Villes::pluck('nom_ville','id_ville');
        return view('admin.index',compact('personnel','tribunal','ville'));
    }  
    /**
    
     * @return l'interface de convocation page 2
     */
    public function next($id){

        $jugement=Jugement::where('num_jugement',$id)->first();
        $nature=Nature::pluck('designation_nature','id_nature');

        return view('admin.convocation',compact('nature','jugement'));
    }


    /**
    
     * fonction pour envoyer des notification
     */
    public function notify(Request $request){

        DB::table('dossiers')->where('num_dossier',$request->num_dossier)->update(['etat'=>1]);

        $token=User::first();
      define( 'API_ACCESS_KEY', 'AAAAJCYMSGg:APA91bHT3HGqYZfC42NpvHTQptA475teR3i38kO660gdOzezGm0DYHArkdC30n9njDfBCj6drRT5OBDkE0lvc8aNJVDWLEqS4pEzEdCgsyuK8Nb2znTLstUipVJQJqmNNPD_-Y1VphH5');

#prep the bundle
     $msg = array
          (
        'body'  => 'لديك خبرة قضائية جديدة',
        'title' => 'خبرة قضائية',
                
          );
    $fields = array
            (
                'to'        => $token->token_notification,
                'notification'  => $msg
            );
    
    
    $headers = array
            (
                'Authorization: key=' . API_ACCESS_KEY,
                'Content-Type: application/json'
            );
#Send Reponse To FireBase Server    
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        echo $result;
        curl_close( $ch );
}  
    
    /**
    
     * inserer une nouvelle convocation
     */
    public function store(Request $request)
    {

       $validator=Validator::make($request->all(),[
            'dossier_num_dossier'=>'required|unique:dossiers,num_dossier',
            'num_jugement'=>'required|unique:jugements,num_jugement',
            'date_jugement'=>'required',
            'nom_juge'=>'required',
            'date_arrivee'=>'required',
            'duree_jugement'=>'required',
            'prix_expertise'=>'required',
            'tribunals_id_tribunal'=>'required',
            'ville_tribunal'=>'required',
            'personnels_id_personnel'=>'required'
        ])->validate();


        $jugement=new Jugement();
        $dossier=new Dossier();
        $dossier->num_dossier=$request->dossier_num_dossier;
        $dossier->etat_dossier='non terminer';
        $dossier->personnels_id_personnel=$request->personnels_id_personnel;
        $dossier->save();
        $jugement->num_jugement=$request->num_jugement;
        $jugement->date_jugement=$request->date_jugement;
        $jugement->nom_juge=$request->nom_juge;
        $jugement->date_arrivee=$request->date_arrivee;
        $jugement->duree_jugement=$request->duree_jugement;
        $jugement->prix_expertise=$request->prix_expertise;
        $jugement->dossiers_num_dossier=$request->dossier_num_dossier;
        $jugement->tribunals_id_tribunal=$request->tribunals_id_tribunal;
        $jugement->save();
        $jugement1=Jugement::where('num_jugement',$request->num_jugement)->where('dossiers_num_dossier',$request->dossier_num_dossier)->where('tribunals_id_tribunal',$request->tribunals_id_tribunal)->first();
        $convocation=new Convocation();
        $convocation->jugements_num_jugement=$request->num_jugement;
        $convocation->jugements_dossiers_num_dossier=$request->dossier_num_dossier;
        $convocation->jugements_tribunals_id_tribunal=$request->tribunals_id_tribunal;
        $convocation->save();


        $tribunal_ville=new Tribunals_villes();
        $tribunal_ville->id_tribunal=$request->tribunals_id_tribunal;
        $tribunal_ville->id_ville=$request->ville_tribunal;
        $tribunal_ville->jugement_id=$request->num_jugement;
        $tribunal_ville->save();
//        $nature=Nature::pluck('designation_nature','id_nature');
//        return view('admin.convocation',compact('nature','jugemen','numdissier','idtribunal'));
        return redirect()->route('convocation.next',$request->num_jugement);
    }


    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
    
    /**
    
     * imprimer les convocation
     */

     public function imprimer(Request $request){
        $id_procureur=[];
        $id_defendeur=[];
        $nom_avocat_pr=[];
        $nom_avocat_de=[];
        $adresse_av_pr=[];
        $avocatpr=[];
        $avocatde=[];
        try{
            $jugement=Jugement::where('num_jugement',$request->num_jugement)->where('dossiers_num_dossier',$request->num_dossier)->where('tribunals_id_tribunal',$request->num_idtribunal)->first();
            $jugements_autres=Jugements_autres::where('jugements_num_jugement',$request->num_jugement)->where('jugements_dossiers_num_dossier',$request->num_dossier)->where('jugements_tribunals_id_tribunal',$request->num_idtribunal)->get();
            $tribunal_ville=Tribunals_villes::where('jugement_id',$jugement->num_jugement)->first();
            $tribunal=Tribunal::where('id_tribunal',$tribunal_ville->id_tribunal)->first();
            $ville=Villes::where('id_ville',$tribunal_ville->id_ville)->first();
            $convocation=Convocation::where('jugements_num_jugement',$request->num_jugement)->where('jugements_dossiers_num_dossier',$request->num_dossier)->where('jugements_tribunals_id_tribunal',$request->num_idtribunal)->first();
            $jugements_procureurs=Jugements_procureurs::where('jugements_num_jugement',$request->num_jugement)->where('jugements_dossiers_num_dossier',$request->num_dossier)->get();
            $jugements_defendeurs=Jugements_defendeurs::where('jugements_num_jugement',$request->num_jugement)->where('jugements_dossiers_num_dossier',$request->num_dossier)->get();
            $immobilier=Immobilier::where('jugements_num_jugement',$request->num_jugement)->where('jugements_dossiers_num_dossier',$request->num_dossier)->where('jugements_tribunals_id_tribunal',$request->num_idtribunal)->get();
            $stk='';

            if($convocation->lieu_convocation=='المكتب'){
                $immobilier=$immobilier[0];
            }else {
                foreach ($immobilier as $im){
                    if($im->num_immobilier==$convocation->lieu_convocation){
                        $stk=$im;
                    }
                }
                $immobilier=$stk;

            }

            $datej=date('d-m-Y h:i', strtotime($jugement->date_jugement));
            $date=explode(' ',$datej);
            $datec=date('Y-m-d H:i', strtotime($convocation->date_convocation));
            $dateconv=explode(' ',$datec);
            //echo $dateconv['0'];


            foreach ($jugements_procureurs as $p=>$jugements_procureur) {
                $procureur = Procureur::where('id_procureur', $jugements_procureur->procureurs_id_procureur)->first();
                if(!empty($procureur)){
                    $id_procureur[] = $procureur->id_procureur;
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $section = $phpWord->addSection();
                    $sectionStyle = $section->getStyle();
// half inch left margin
                    $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(15));
                    $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(11));
                    $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(19));
                    $phpWord->setDefaultFontName('Arial');
                    $fancyTableStyleName = 'Fancy Table';
                    $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 40, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
                    $fancyTableFirstRowStyle1 = array('bgColor' => 'FFFFFF');
                    $fancyTableCellStyle = array('valign' => 'center');

                    $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle1);
                    $table = $section->addTable($fancyTableStyleName);
                    $table->addRow();
                    $table->addCell(12000, $fancyTableCellStyle)->addText(htmlspecialchars(':المرسل إليه ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center"));
                    $table->addCell(12000, $fancyTableCellStyle)->addText(htmlspecialchars(':المرسل  ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center"));
                    $table->addRow();
                    $c1=$table->addCell(12000);
                    $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                    $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                    if($procureur->genre=='M'){
                        $c1->addText(htmlspecialchars("السيد :$procureur->nom_procureur ", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => array('line' => 220)));
                    }else if($procureur->genre=='F'){
                        $c1->addText(htmlspecialchars("السيدة :$procureur->nom_procureur ", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => array('line' => 220)));
                    }
                    $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                    $c1->addText(htmlspecialchars("العنوان:$procureur->adresse_procureur", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => true, 'name' => 'arial'), array("align" => "right", 'space' => array('line' => 220)));

                    $c2 = $table->addCell(12000);
                    $c2->addText(htmlspecialchars('الخبير محمد لازم', ENT_COMPAT, 'UTF-8'), array('size' => 20, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
                    $c2->addText(htmlspecialchars('خبير قضائي  محلف لدى محكمة الاستئناف  بالدار البيضاء', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars(' لندن --RICS عضو في المنظمة الدولية للخبراء العقاريين -  خبير دولي في العقار', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('مهندس دولة  في  الهندسة المدنية', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('« DCIS / DCES / DCIE » خبير معتمد في مراكز البيانات', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('X-Collège Polytechnique de Paris - ماجستير في تسيير المشاريع', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('دبلوم الدراسات الاقتصادية  و القانونية المطبقة في البناء و السكنى', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true));
                    $c2->addText(htmlspecialchars(' ،13 الطابق,193 شارع الحسن الثاني، عمارة رقم : عنوان المكتب  .الدار البيضاء, 26 رقم  ', ENT_COMPAT, 'UTF-8'), array('size' => 12, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true));

                    $section->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true), array('bold' => true, 'rtl' => true, 'size' => 22), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
                    $section->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;
                    $section->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;
//            $section->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;

                    $textrun1 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                    $textrun1->addText("$request->num_dossier".' ', $styleFont);
                    $textrun1->addText("     :     رقم ملف    -     ".' ', $styleFont2);

                    $textrun2 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                    $textrun2->addText("$request->num_jugement".' ', $styleFont);
                    $textrun2->addText("     :     عدد حكم    -     ".' ', $styleFont2);
                    $tarikh=date('d/m/Y', strtotime($jugement->date_jugement));
                    $textrun3 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                    $textrun3->addText("$tarikh".' ', $styleFont);
                    $textrun3->addText("     :      بتاريخ    -     ".' ', $styleFont2);


                    $section->addText(htmlspecialchars('استدعاء', ENT_COMPAT, 'UTF-8'), array('size' => 36, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
                    $section->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true), array("align" => "right"));;

                    $textrun4 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont2 = array('bold'=>false, 'size'=>16, 'name'=>'arial');
                    $textrun4->addText( " ,وبعد طيبة تحية\t".' ', $styleFont2);
                    if($ville->nom_ville=='الدار البيضاء'){
                        if($tribunal->nom_tribunal=='محكمة الاستئناف'){
                            $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                        }else{
                            $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  المدنية ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                        }
                    }else{
                        $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                    }
                    $section->addText(htmlspecialchars("المشار إليه أعلاه  و بناءا على المقتضيات الواردة في الحكم ذي المراجع أعلاه ", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;
                    $textrun5 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                    if($procureur->genre=='M') {
                        $textrun5->addText("نطلب من السيد: " . ' ', $styleFont2);
                    }else if($procureur->genre=='F'){
                        $textrun5->addText("نطلب من السيدة: " . ' ', $styleFont2);

                    }
                    $textrun5->addText("$procureur->nom_procureur".' ', array('rtl'=>true,'bold'=>false,'bold'=>true, 'size'=>16, 'name'=>'arial'));

                    $tarikh=date('Y/m/d',strtotime($dateconv[0]));
                    $textrun6 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                    $textrun6->addText(". $convocation->heure_convocation. $dateconv[1]  الساعة على $tarikh  ".' ', $styleFont);

                    $textrun6->addText( "الحضور يوم: ".' ', $styleFont2);


//            $section->addText(htmlspecialchars("  . صباحا.   $dateconv[1]   على الساعة $dateconv[0] :  الحضور يوم  ", ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;

                    if ($convocation->lieu_convocation === "المكتب") {
                        $textrun7 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                        $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                        $styleFont2 = array('bold'=>false, 'size'=>16, 'name'=>'arial');
                        $textrun7->addText("$convocation->lieu_convocation".' ', $styleFont);
                        $textrun7->addText( ": التالي العنوان إلى \t".' ', $styleFont2);
                        // $section->addText(htmlspecialchars(" $convocation->lieu_convocation :إلى العنوان التالي ", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;

                    } else {
                        $textrun8 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>2500,'align'=>'right'));
                        $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                        $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                        $textrun8->addText("(   $immobilier->num_immobilier  عدد العقاري الرسم ذي الخبرة موضوع العقار )المكان عين".' ', $styleFont);
                        $textrun8->addText( "إلى العنوان التالي: ".' ', $styleFont2);

                    }
                    $section->addText(htmlspecialchars(".و ذلك قصد القيام بالمهمة المسندة إلي من طرف المحكمة", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;



//            $section1 = $phpWord->addSection(array('marginRight'=>10,'marginLeft'=>2500,'marginTop'=>(-1000),'align'=>'right'));
                    //$section->setStyle();
                    $textrun9 = $section->addTextRun(array('marginRight'=>10,'align'=>'right'));
                    $styleFont = array('bold'=>false, 'size'=>14, 'name'=>'arial','underline'=>'single');
                    $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>14, 'name'=>'arial');
                    $textrun9->addText("الرجاء منكم الحضور في التاريخ المحدد مصحوبين بجميع الحجج والوثائق والأدلة الضرورية".' ', $styleFont2);
                    $textrun9->addText( "  :  خلاصة".' ', $styleFont);
                    //$section->addText(htmlspecialchars(" .الرجاء منكم الحضور في التاريخ المحدد مصحوبين بجميع الحجج والوثائق والأدلة الضرورية  ", ENT_COMPAT, 'UTF-8'), array('size'=>14,'bold'=>false,'name'=>'Times New Roman'),array("align" => "right"));;
                    $section->addText(htmlspecialchars(" .والسلام ", ENT_COMPAT, 'UTF-8'), array('size'=>14,'bold'=>false,'name'=>'Times New Roman'),array("align" => "right"));;

//            $file = 'HelloWorld.'.$key.'.docx';
//            header("Content-Description: File Transfer");
//            header('Content-Disposition: attachment; filename="' . $file . '"');
//            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
//            header('Content-Transfer-Encoding: binary');
//            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//            header('Expires: 0');
                    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    $xmlWriter->save("uploads/PROCUREUR_{$p}.docx");
                }
            }
//        }
            foreach ($jugements_defendeurs as $d=>$jugements_defendeur){
                $defendeur=Defendeur::where('id_defendeur',$jugements_defendeur->defendeurs_id_defendeur)->first();
                if(!empty($defendeur)){
                    $id_defendeur[]=$defendeur->id_defendeur;
                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $section = $phpWord->addSection();
                    $sectionStyle = $section->getStyle();
// half inch left margin
                    $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(15));
                    $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(11));
                    $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(19));
                    $phpWord->setDefaultFontName('Arial');
                    $fancyTableStyleName = 'Fancy Table';
                    $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 40, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
                    $fancyTableFirstRowStyle1 = array('bgColor' => 'FFFFFF');
                    $fancyTableCellStyle = array('valign' => 'center');

                    $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle1);
                    $table = $section->addTable($fancyTableStyleName);
                    $table->addRow();
                    $table->addCell(12000, $fancyTableCellStyle)->addText(htmlspecialchars(':المرسل إليه ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center"));
                    $table->addCell(12000, $fancyTableCellStyle)->addText(htmlspecialchars(':المرسل  ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center"));
                    $table->addRow();
                    $c1=$table->addCell(12000);
                    $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                    $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                    if($defendeur->genre=='M') {
                        $c1->addText(htmlspecialchars("السيد :$defendeur->nom_defendeur ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => array('line' => 220)));
                    }else if($defendeur->genre=='F'){
                        $c1->addText(htmlspecialchars("السيدة :$defendeur->nom_defendeur ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => array('line' => 220)));
                    }
                    $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                    $c1->addText(htmlspecialchars("العنوان:$defendeur->adresse_defendeur", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => true, 'name' => 'arial'), array("align" => "right", 'space' => array('line' => 220)));
                    $c2 = $table->addCell(12000);
                    $c2->addText(htmlspecialchars('الخبير محمد لازم', ENT_COMPAT, 'UTF-8'), array('size' => 20, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
                    $c2->addText(htmlspecialchars('خبير قضائي  محلف لدى محكمة الاستئناف  بالدار البيضاء', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars(' لندن --RICS عضو في المنظمة الدولية للخبراء العقاريين -  خبير دولي في العقار', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('مهندس دولة  في  الهندسة المدنية', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('« DCIS / DCES / DCIE » خبير معتمد في مراكز البيانات', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('X-Collège Polytechnique de Paris - ماجستير في تسيير المشاريع', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('دبلوم الدراسات الاقتصادية  و القانونية المطبقة في البناء و السكنى', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true));
                    $c2->addText(htmlspecialchars(' ،13 الطابق,193 شارع الحسن الثاني، عمارة رقم : عنوان المكتب  .الدار البيضاء, 26 رقم  ', ENT_COMPAT, 'UTF-8'), array('size' => 12, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true));

                    $section->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true), array('bold' => true, 'rtl' => true, 'size' => 22), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
                    $section->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;
                    $section->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;
//            $section->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;

                    $textrun1 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                    $textrun1->addText("$request->num_dossier".' ', $styleFont);
                    $textrun1->addText("     :     رقم ملف    -     ".' ', $styleFont2);

                    $textrun2 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                    $textrun2->addText("$request->num_jugement".' ', $styleFont);
                    $textrun2->addText("     :     عدد حكم    -     ".' ', $styleFont2);
                    $tarikh=date('d/m/Y', strtotime($jugement->date_jugement));
                    $textrun3 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                    $textrun3->addText("$tarikh".' ', $styleFont);
                    $textrun3->addText("     :      بتاريخ    -     ".' ', $styleFont2);


                    $section->addText(htmlspecialchars('استدعاء', ENT_COMPAT, 'UTF-8'), array('size' => 36, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
                    $section->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true), array("align" => "right"));;

                    $textrun4 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont2 = array('bold'=>false, 'size'=>16, 'name'=>'arial');
                    $textrun4->addText( " ,وبعد طيبة تحية\t".' ', $styleFont2);
                    if($ville->nom_ville=='الدار البيضاء'){
                        if($tribunal->nom_tribunal=='محكمة الاستئناف'){
                            $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                        }else{
                            $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  المدنية ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                        }
                    }else{
                        $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                    }

                    $section->addText(htmlspecialchars("المشار إليه أعلاه  و بناءا على المقتضيات الواردة في الحكم ذي المراجع أعلاه ", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;
                    $textrun5 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                    if($defendeur->genre=='M') {
                        $textrun5->addText("نطلب من السيد: " . ' ', $styleFont2);
                    }else if($defendeur->genre=='F'){
                        $textrun5->addText("نطلب من السيدة: " . ' ', $styleFont2);

                    }
                    $textrun5->addText("$defendeur->nom_defendeur".' ', array('rtl'=>true, 'size'=>16, 'name'=>'arial'));
                    $tarikh=date('Y/m/d',strtotime($dateconv[0]));
                    $textrun6 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                    $textrun6->addText(". $convocation->heure_convocation. $dateconv[1]  الساعة على $tarikh  ".' ', $styleFont);

                    $textrun6->addText( "الحضور يوم: ".' ', $styleFont2);


//            $section->addText(htmlspecialchars("  . صباحا.   $dateconv[1]   على الساعة $dateconv[0] :  الحضور يوم  ", ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;

                    if ($convocation->lieu_convocation === "المكتب") {
                        $textrun7 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                        $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                        $styleFont2 = array('bold'=>false, 'size'=>16, 'name'=>'arial');
                        $textrun7->addText("$convocation->lieu_convocation".' ', $styleFont);
                        $textrun7->addText( ": التالي العنوان إلى \t".' ', $styleFont2);
                        // $section->addText(htmlspecialchars(" $convocation->lieu_convocation :إلى العنوان التالي ", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;

                    } else {
                        $textrun8 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>2500,'align'=>'right'));
                        $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                        $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                        $textrun8->addText("(   $immobilier->num_immobilier  عدد العقاري الرسم ذي الخبرة موضوع العقار )المكان عين".' ', $styleFont);
                        $textrun8->addText( "إلى العنوان التالي: ".' ', $styleFont2);

                    }
                    $section->addText(htmlspecialchars(".و ذلك قصد القيام بالمهمة المسندة إلي من طرف المحكمة", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;



//            $section1 = $phpWord->addSection(array('marginRight'=>10,'marginLeft'=>2500,'marginTop'=>(-1000),'align'=>'right'));
                    //$section->setStyle();
                    $textrun9 = $section->addTextRun(array('marginRight'=>10,'align'=>'right'));
                    $styleFont = array('bold'=>false, 'size'=>14, 'name'=>'arial','underline'=>'single');
                    $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>14, 'name'=>'arial');
                    $textrun9->addText("الرجاء منكم الحضور في التاريخ المحدد مصحوبين بجميع الحجج والوثائق والأدلة الضرورية".' ', $styleFont2);
                    $textrun9->addText( "  :  خلاصة".' ', $styleFont);
                    //$section->addText(htmlspecialchars(" .الرجاء منكم الحضور في التاريخ المحدد مصحوبين بجميع الحجج والوثائق والأدلة الضرورية  ", ENT_COMPAT, 'UTF-8'), array('size'=>14,'bold'=>false,'name'=>'Times New Roman'),array("align" => "right"));;
                    $section->addText(htmlspecialchars(" .والسلام ", ENT_COMPAT, 'UTF-8'), array('size'=>14,'bold'=>false,'name'=>'Times New Roman'),array("align" => "right"));;

//            $file = 'HelloWorld.'.$key.'.docx';
//            header("Content-Description: File Transfer");
//            header('Content-Disposition: attachment; filename="' . $file . '"');
//            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
//            header('Content-Transfer-Encoding: binary');
//            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//            header('Expires: 0');
                    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    $xmlWriter->save("uploads/DEFENDEUR.{$d}.docx");
                }
            }

            $l=0;
            foreach ($id_procureur as $v){


                $procureurs_avocats=Procureurs_avocats::where('procureurs_id_procureur',$v)->get();
                if(!empty($procureurs_avocats)){
                    foreach ($procureurs_avocats as $procureurs_avocat) {

                        $avocat=Avocat::where('id_avocat',$procureurs_avocat->avocats_id_avocat)->first();


                        $adresse_av_pr[]=$avocat->adresse_avocat;
                        $nom_avocat_pr[]=$avocat->nom_avocat;
                        $avocatpr[]=$avocat;
                    }

                }

            }
            $nom_av=array_unique($nom_avocat_pr);
            foreach ($nom_av as $i=>$nameav){
                $l++;
                $phpWord = new \PhpOffice\PhpWord\PhpWord();
                $section = $phpWord->addSection();
                $sectionStyle = $section->getStyle();
// half inch left margin
                $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(15));
                $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(11));
                $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(19));
                $fancyTableStyleName = 'Fancy Table';
                $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 40, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
                $fancyTableFirstRowStyle1 = array('bgColor' => 'FFFFFF');
                $fancyTableCellStyle = array('valign' => 'center');

                $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle1);
                $table = $section->addTable($fancyTableStyleName);
                $table->addRow(40);
                $table->addCell(12000, $fancyTableCellStyle)->addText(htmlspecialchars(':المرسل إليه ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center"));
                $table->addCell(12000, $fancyTableCellStyle)->addText(htmlspecialchars(':المرسل  ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center"));
                $table->addRow();
                $c1=$table->addCell(12000);
                $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                if($avocatpr[$i]->genre=='M') {
                    $c1->addText(htmlspecialchars(" الأستاذ : $nameav  ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => array('line' => 220)));
                } if($avocatpr[$i]->genre=='F') {
                    $c1->addText(htmlspecialchars(" الأستاذة : $nameav  ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => array('line' => 220)));
                }
                $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                $c1->addText(htmlspecialchars("$adresse_av_pr[$i] ", ENT_COMPAT, 'UTF-8'),  array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => array('line' => 220)));

                $c2 = $table->addCell(12000);
                $c2->addText(htmlspecialchars('الخبير محمد لازم', ENT_COMPAT, 'UTF-8'), array('size' => 20, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
                $c2->addText(htmlspecialchars('خبير قضائي  محلف لدى محكمة الاستئناف  بالدار البيضاء', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                $c2->addText(htmlspecialchars(' لندن --RICS عضو في المنظمة الدولية للخبراء العقاريين -  خبير دولي في العقار', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                $c2->addText(htmlspecialchars('مهندس دولة  في  الهندسة المدنية', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                $c2->addText(htmlspecialchars('« DCIS / DCES / DCIE » خبير معتمد في مراكز البيانات', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                $c2->addText(htmlspecialchars('X-Collège Polytechnique de Paris - ماجستير في تسيير المشاريع', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                $c2->addText(htmlspecialchars('دبلوم الدراسات الاقتصادية  و القانونية المطبقة في البناء و السكنى', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                $c2->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true));
                $c2->addText(htmlspecialchars(' ،13 الطابق,193 شارع الحسن الثاني، عمارة رقم : عنوان المكتب  .الدار البيضاء, 26 رقم  ', ENT_COMPAT, 'UTF-8'), array('size' => 12, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                $c2->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true));

                $section->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;


                $textrun1 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                $textrun1->addText("$request->num_dossier".' ', $styleFont);
                $textrun1->addText("     :     رقم ملف    -     ".' ', $styleFont2);

                $textrun2 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                $textrun2->addText("$request->num_jugement".' ', $styleFont);
                $textrun2->addText("     :     عدد حكم    -     ".' ', $styleFont2);
                $tarikh=date('d/m/Y', strtotime($jugement->date_jugement));
                $textrun3 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                $textrun3->addText("$tarikh".' ', $styleFont);
                $textrun3->addText("     :      بتاريخ    -     ".' ', $styleFont2);

                $section->addText(htmlspecialchars('استدعاء', ENT_COMPAT, 'UTF-8'), array('size' => 36, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
                $section->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true), array("align" => "right"));;

                $textrun4 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                $styleFont2 = array('bold'=>false, 'size'=>16, 'name'=>'arial');
                $textrun4->addText( " ,وبعد طيبة تحية\t".' ', $styleFont2);
                if($ville->nom_ville=='الدار البيضاء'){
                    if($tribunal->nom_tribunal=='محكمة الاستئناف'){
                        $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                    }else{
                        $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  المدنية ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                    }
                }else{
                    $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                }
                $section->addText(htmlspecialchars("المشار إليه أعلاه  و بناءا على المقتضيات الواردة في الحكم ذي المراجع أعلاه ", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;
                $textrun5 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                if($avocatpr[$i]->genre=='M') {
                    $textrun5->addText("نطلب من الأستاذ: " . ' ', $styleFont2);
                }if($avocatpr[$i]->genre=='F') {
                    $textrun5->addText("نطلب من الأستاذة : " . ' ', $styleFont2);
                }
                $textrun5->addText("$nameav".' ', array('rtl'=>true, 'size'=>16, 'name'=>'arial'));
                $tarikh=date('Y/m/d',strtotime($dateconv[0]));
                $textrun6 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                $textrun6->addText(". $convocation->heure_convocation. $dateconv[1]  الساعة على $tarikh  ".' ', $styleFont);
                $textrun6->addText( "الحضور يوم: ".' ', $styleFont2);


//            $section->addText(htmlspecialchars("  . صباحا.   $dateconv[1]   على الساعة $dateconv[0] :  الحضور يوم  ", ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;

                if ($convocation->lieu_convocation === "المكتب") {
                    $textrun7 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('bold'=>false, 'size'=>16, 'name'=>'arial');
                    $textrun7->addText("$convocation->lieu_convocation".' ', $styleFont);
                    $textrun7->addText( ": التالي العنوان إلى \t".' ', $styleFont2);
                    // $section->addText(htmlspecialchars(" $convocation->lieu_convocation :إلى العنوان التالي ", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;

                } else {
                    $textrun8 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>2500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                    $textrun8->addText("(   $immobilier->num_immobilier  عدد العقاري الرسم ذي الخبرة موضوع العقار )المكان عين".' ', $styleFont);
                    $textrun8->addText( "إلى العنوان التالي: ".' ', $styleFont2);

                }
                $section->addText(htmlspecialchars(".و ذلك قصد القيام بالمهمة المسندة إلي من طرف المحكمة", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
                $section->addText(htmlspecialchars("للإشارة، قد نجد صعوبة في تبليغ موكلكم، وعليه نرجو منكم التكرم بإبلاغ موكلكم بتاريخ ومكان الخبرة", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;
                $section->addText(htmlspecialchars(" .المشار إليهما أعلاه، شاكرين لكم حسن التعاون", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;
                $section->addText(htmlspecialchars(". وتقبلوا مني فائق الإحترام والتقدير ", ENT_COMPAT, 'UTF-8'), array('size' => 15, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;
                $section->addText(htmlspecialchars(" .والسلام", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;






                $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                $xmlWriter->save("uploads/AVOCAT_PROCUREUR.{$l}.docx");
            }



            $z=0;
            foreach ($id_defendeur as $v1){


                $defendeurs_avocats=Defendeurs_avocats::where('defendeurs_id_defendeur',$v1)->get();
                if(!empty($defendeurs_avocats)){
                    foreach ($defendeurs_avocats as $defendeurs_avocat) {

                        $avocat=Avocat::where('id_avocat',$defendeurs_avocat->avocats_id_avocat)->first();

                        $nom_avocat_de[]=$avocat->nom_avocat;
                        $adresse_av_de[]=$avocat->adresse_avocat;
                        $avocatde[]=$avocat;
                    }
                }

            }
            $nom_av_de=array_unique($nom_avocat_de);
            foreach ($nom_av_de as $h=>$nameavde){
                $z++;
                $phpWord = new \PhpOffice\PhpWord\PhpWord();
                $section = $phpWord->addSection();
                $sectionStyle = $section->getStyle();
// half inch left margin
                $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(15));
                $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(11));
                $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(19));
                $fancyTableStyleName = 'Fancy Table';
                $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 40, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
                $fancyTableFirstRowStyle1 = array('bgColor' => 'FFFFFF');
                $fancyTableCellStyle = array('valign' => 'center');

                $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle1);
                $table = $section->addTable($fancyTableStyleName);
                $table->addRow(40);
                $table->addCell(12000, $fancyTableCellStyle)->addText(htmlspecialchars(':المرسل إليه ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center"));
                $table->addCell(12000, $fancyTableCellStyle)->addText(htmlspecialchars(':المرسل  ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center"));
                $table->addRow();
                $c1=$table->addCell(12000);
                $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                if($avocatde[$h]->genre=='M'){
                    $c1->addText(htmlspecialchars(" الأستاذ : $nameavde  ", ENT_COMPAT, 'UTF-8'),  array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => array('line' => 220)));
                } if($avocatde[$h]->genre=='F'){
                    $c1->addText(htmlspecialchars(" الأستاذة : $nameavde  ", ENT_COMPAT, 'UTF-8'),  array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => array('line' => 220)));
                }

                $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                $c1->addText(htmlspecialchars("$adresse_av_de[$h] ", ENT_COMPAT, 'UTF-8'),  array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => array('line' => 220)));

                $c2 = $table->addCell(12000);
                $c2->addText(htmlspecialchars('الخبير محمد لازم', ENT_COMPAT, 'UTF-8'), array('size' => 20, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
                $c2->addText(htmlspecialchars('خبير قضائي  محلف لدى محكمة الاستئناف  بالدار البيضاء', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                $c2->addText(htmlspecialchars(' لندن --RICS عضو في المنظمة الدولية للخبراء العقاريين -  خبير دولي في العقار', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                $c2->addText(htmlspecialchars('مهندس دولة  في  الهندسة المدنية', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                $c2->addText(htmlspecialchars('« DCIS / DCES / DCIE » خبير معتمد في مراكز البيانات', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                $c2->addText(htmlspecialchars('X-Collège Polytechnique de Paris - ماجستير في تسيير المشاريع', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                $c2->addText(htmlspecialchars('دبلوم الدراسات الاقتصادية  و القانونية المطبقة في البناء و السكنى', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                $c2->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true));
                $c2->addText(htmlspecialchars(' ،13 الطابق,193 شارع الحسن الثاني، عمارة رقم : عنوان المكتب  .الدار البيضاء, 26 رقم  ', ENT_COMPAT, 'UTF-8'), array('size' => 12, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                $c2->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true));

                $section->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;


                $textrun1 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                $textrun1->addText("$request->num_dossier".' ', $styleFont);
                $textrun1->addText("     :     رقم ملف    -     ".' ', $styleFont2);

                $textrun2 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                $textrun2->addText("$request->num_jugement".' ', $styleFont);
                $textrun2->addText("     :     عدد حكم    -     ".' ', $styleFont2);
                $tarikh=date('d/m/Y', strtotime($jugement->date_jugement));
                $textrun3 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                $textrun3->addText("$tarikh".' ', $styleFont);
                $textrun3->addText("     :      بتاريخ    -     ".' ', $styleFont2);

                $section->addText(htmlspecialchars('استدعاء', ENT_COMPAT, 'UTF-8'), array('size' => 36, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
                $section->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true), array("align" => "right"));;

                $textrun4 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                $styleFont2 = array('bold'=>false, 'size'=>16, 'name'=>'arial');
                $textrun4->addText( " ,وبعد طيبة تحية\t".' ', $styleFont2);
                if($ville->nom_ville=='الدار البيضاء'){
                    if($tribunal->nom_tribunal=='محكمة الاستئناف'){
                        $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                    }else{
                        $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  المدنية ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                    }
                }else{
                    $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                }
                $section->addText(htmlspecialchars("المشار إليه أعلاه  و بناءا على المقتضيات الواردة في الحكم ذي المراجع أعلاه ", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;
                $textrun5 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                if($avocatde[$h]->genre=="M"){
                    $textrun5->addText( "نطلب من الأستاذ : ".' ', $styleFont2);
                }
                if($avocatde[$h]->genre=="F"){
                    $textrun5->addText( "نطلب من الأستاذة : ".' ', $styleFont2);
                }

                $textrun5->addText("$nameavde".' ', array('rtl'=>true, 'size'=>16, 'name'=>'arial'));
                $tarikh=date('Y/m/d',strtotime($dateconv[0]));
                $textrun6 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                $textrun6->addText(". $convocation->heure_convocation. $dateconv[1]  الساعة على $tarikh  ".' ', $styleFont);

                $textrun6->addText( "الحضور يوم: ".' ', $styleFont2);


//            $section->addText(htmlspecialchars("  . صباحا.   $dateconv[1]   على الساعة $dateconv[0] :  الحضور يوم  ", ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;

                if ($convocation->lieu_convocation === "المكتب") {
                    $textrun7 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('bold'=>false, 'size'=>16, 'name'=>'arial');
                    $textrun7->addText("$convocation->lieu_convocation".' ', $styleFont);
                    $textrun7->addText( ": التالي العنوان إلى \t".' ', $styleFont2);
                    // $section->addText(htmlspecialchars(" $convocation->lieu_convocation :إلى العنوان التالي ", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;

                } else {
                    $textrun8 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>2500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                    $textrun8->addText("(   $immobilier->num_immobilier  عدد العقاري الرسم ذي الخبرة موضوع العقار )المكان عين".' ', $styleFont);
                    $textrun8->addText( "إلى العنوان التالي: ".' ', $styleFont2);

                }
                $section->addText(htmlspecialchars(".و ذلك قصد القيام بالمهمة المسندة إلي من طرف المحكمة", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
                $section->addText(htmlspecialchars("للإشارة، قد نجد صعوبة في تبليغ موكلكم، وعليه نرجو منكم التكرم بإبلاغ موكلكم بتاريخ ومكان الخبرة", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;
                $section->addText(htmlspecialchars(" .المشار إليهما أعلاه، شاكرين لكم حسن التعاون", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;
                $section->addText(htmlspecialchars(". وتقبلوا مني فائق الإحترام والتقدير ", ENT_COMPAT, 'UTF-8'), array('size' => 15, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;
                $section->addText(htmlspecialchars(" .والسلام", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;



                $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                $xmlWriter->save("uploads/AVOCAT_DEFENDEUR_{$z}.docx");
            }

            if(!empty($jugements_autres)){
                foreach ($jugements_autres as $key=>$jugements_autre) {
                    $autre = Autre::where('id_autre', $jugements_autre->autres_id_autre)->first();

                    $phpWord = new \PhpOffice\PhpWord\PhpWord();
                    $section = $phpWord->addSection();
                    $sectionStyle = $section->getStyle();
// half inch left margin
                    $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(15));
                    $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(11));
                    $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(19));
                    $phpWord->setDefaultFontName('Arial');
                    $fancyTableStyleName = 'Fancy Table';
                    $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 40, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
                    $fancyTableFirstRowStyle1 = array('bgColor' => 'FFFFFF');
                    $fancyTableCellStyle = array('valign' => 'center');

                    $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle1);
                    $table = $section->addTable($fancyTableStyleName);
                    $table->addRow(40);
                    $table->addCell(12000, $fancyTableCellStyle)->addText(htmlspecialchars(':المرسل إليه ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center"));
                    $table->addCell(12000, $fancyTableCellStyle)->addText(htmlspecialchars(':المرسل  ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center"));
                    $table->addRow();
                    $c1=$table->addCell(12000);
                    $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                    $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));

                    $c1->addText(htmlspecialchars("$autre->description_autre  ", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'rtl' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                    $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));
                    $c1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'space' => array('line' => 220)));

                    $c2 = $table->addCell(12000);
                    $c2->addText(htmlspecialchars('الخبير محمد لازم', ENT_COMPAT, 'UTF-8'), array('size' => 20, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));


                    $c2->addText(htmlspecialchars('خبير قضائي  محلف لدى محكمة الاستئناف  بالدار البيضاء', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars(' لندن --RICS عضو في المنظمة الدولية للخبراء العقاريين -  خبير دولي في العقار', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('مهندس دولة  في  الهندسة المدنية', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('« DCIS / DCES / DCIE » خبير معتمد في مراكز البيانات', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('X-Collège Polytechnique de Paris - ماجستير في تسيير المشاريع', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('دبلوم الدراسات الاقتصادية  و القانونية المطبقة في البناء و السكنى', ENT_COMPAT, 'UTF-8'), array('size' => 9.5, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true));
                    $c2->addText(htmlspecialchars(' ،13 الطابق,193 شارع الحسن الثاني، عمارة رقم : عنوان المكتب  .الدار البيضاء, 26 رقم  ', ENT_COMPAT, 'UTF-8'), array('size' => 12, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));
                    $c2->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true));

                    $section->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true), array('bold' => true, 'rtl' => true, 'size' => 22), array("align" => "right"));;
                    $section->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;
//            $section->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;
                    $textrun1 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                    $textrun1->addText("$request->num_dossier".' ', $styleFont);
                    $textrun1->addText("     :     رقم ملف    -     ".' ', $styleFont2);

                    $textrun2 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                    $textrun2->addText("$request->num_jugement".' ', $styleFont);
                    $textrun2->addText("     :     عدد حكم    -     ".' ', $styleFont2);
                    $tarikh=date('d/m/Y', strtotime($jugement->date_jugement));
                    $textrun3 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
                    $textrun3->addText("$tarikh".' ', $styleFont);
                    $textrun3->addText("     :      بتاريخ    -     ".' ', $styleFont2);

                    $section->addText(htmlspecialchars('استدعاء', ENT_COMPAT, 'UTF-8'), array('size' => 36, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
                    $section->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true), array("align" => "right"));;

                    $textrun4 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont2 = array('bold'=>false, 'size'=>16, 'name'=>'arial');
                    $textrun4->addText( " ,وبعد طيبة تحية\t".' ', $styleFont2);
                    if($ville->nom_ville=='الدار البيضاء'){
                        if($tribunal->nom_tribunal=='محكمة الاستئناف'){
                            $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                        }else{
                            $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  المدنية ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                        }
                    }else{
                        $section->addText(htmlspecialchars(" بناءا على الحكم الصادر عن $tribunal->nom_tribunal  ب$ville->nom_ville القاضي بتعييني خبيرا في الملف", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                    }
                    $section->addText(htmlspecialchars("المشار إليه أعلاه  و بناءا على المقتضيات  ", ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;
                    $section->addText(htmlspecialchars(" الواردة في الحكم ذي المراجع أعلاه ", ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;

                    $textrun5 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('rtl'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                    $textrun5->addText( "نطلب منكم: ".' ', $styleFont2);
                    $textrun5->addText("$autre->description_autre".' ', $styleFont);

                    $tarikh=date('Y/m/d',strtotime($dateconv[0]));
                    $textrun6 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                    $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                    $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                    $textrun6->addText(". $convocation->heure_convocation. $dateconv[1]  الساعة على $tarikh  ".' ', $styleFont);

                    $textrun6->addText( "الحضور يوم: ".' ', $styleFont2);
                    if ($convocation->lieu_convocation === "المكتب") {
                        $textrun7 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right'));
                        $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                        $styleFont2 = array('bold'=>false, 'size'=>16, 'name'=>'arial');
                        $textrun7->addText("$convocation->lieu_convocation".' ', $styleFont);
                        $textrun7->addText( ": التالي العنوان إلى \t".' ', $styleFont2);
                        // $section->addText(htmlspecialchars(" $convocation->lieu_convocation :إلى العنوان التالي ", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "right"));;

                    } else {
                        $textrun8 = $section->addTextRun(array('marginRight'=>10,'marginLeft'=>2500,'align'=>'right'));
                        $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
                        $styleFont2 = array('rtl'=>true,'bold'=>false, 'size'=>16, 'name'=>'arial');
                        $textrun8->addText("(   $immobilier->num_immobilier  عدد العقاري الرسم ذي الخبرة موضوع العقار )المكان عين".' ', $styleFont);
                        $textrun8->addText( "إلى العنوان التالي: ".' ', $styleFont2);

                    }
                    $section->addText(htmlspecialchars(".و ذلك قصد القيام بالمهمة المسندة إلي من طرف المحكمة", ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "right"));;





                    $section->addText(htmlspecialchars(" .وتقبلوا مني سيدي فائق الإحترام والتقدير ", ENT_COMPAT, 'UTF-8'), array('size'=>16,'bold'=>false,'name'=>'Times New Roman'),array("align" => "right"));;
                    $section->addText(htmlspecialchars(" .والسلام ", ENT_COMPAT, 'UTF-8'), array('size'=>16,'bold'=>false,'name'=>'Times New Roman'),array("align" => "right"));;

//            $file = 'HelloWorld.'.$key.'.docx';
//            header("Content-Description: File Transfer");
//            header('Content-Disposition: attachment; filename="' . $file . '"');
//            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
//            header('Content-Transfer-Encoding: binary');
//            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//            header('Expires: 0');
                    $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
                    $xmlWriter->save("uploads/MOHAFID.{$key}.docx");
                }
            }
            $file_folder = base_path("uploads");

            $zip = new ZipArchive(); // Load zip library
            $zip_name = time() . ".zip";           // Zip name
            $zip->open($zip_name, ZIPARCHIVE::CREATE);
            $files=scandir($file_folder);
            unset($files[0],$files[1]);
            foreach ($files as $file){
                $zip->addFile($file_folder . "/{$file}","uploads/{$file}"); // Adding files into zip


            }


            $zip->close();

            // push to download the zip
            header('Content-type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zip_name . '"');
            readfile($zip_name);
            // remove zip file is exists in temp path
            unlink($zip_name);
            foreach ($files as $file){
                Storage::delete($file);

            }
        }
        catch(\Exception $e){
            return redirect()->route('dossier.getDossier');
        }

    }
}