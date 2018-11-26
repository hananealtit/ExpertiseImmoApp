<?php



namespace App\Http\Controllers;

/**



 * declaration des dependance

 */

use PhpOffice\PhpPresentation\Style\Border;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Fill;

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\DocumentLayout;

use PhpOffice\PhpPresentation\Shape\RichText\Run;



use App\Arrivant;

use App\Autre;

use App\Avocat;

use App\Batiment;

use App\Convocation;

use App\Decision;

use App\DecisionJugement;

use App\Defendeur;

use App\Defendeurs_avocats;

use App\Defendeurs_immobiliers;

use App\Dossier;

use App\Immobilier;

use App\Immobiliers_natures;

use App\Jugement;

use App\Jugement_decision;

use App\Jugements_autres;

use App\Jugements_defendeurs;

use App\Jugements_procureurs;

use App\Nature;

use App\Personnel;

use App\Procureur;

use App\Procureurs_avocats;

use App\Procureurs_immobiliers;

use App\Sous_batiment;

use App\Tribunal;

use App\Tribunals_villes;

use App\Villes;

use App\Reports_contents;

use App\Reports_contents_imgs;

use Carbon\Carbon;

use Faker\Provider\DateTime;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;

use PhpOffice\PhpWord\TemplateProcessor;

use Illuminate\Support\Facades\Auth;

class DossierController extends Controller

{

    /**



     * creer header du chaque slide

     */
    public function createHeaderReport($Slide){

        $shapeHeader = $Slide->createTableShape(3);
        $shapeHeader->getBorder()->setColor(new Color('FF52302d'));
        $shapeHeader->setHeight(70);
        $shapeHeader->setWidth(800);
        // Modifier la position du shape
        $shapeHeader->setOffsetX(0);
        $shapeHeader->setOffsetY(10);


        // Add row

        $row = $shapeHeader->createRow();
        $row->getFill()
            ->setFillType(Fill::FILL_GRADIENT_LINEAR)
            ->setRotation(90)->setStartColor(new Color('FF52302d'))
            ->setEndColor(new Color('FF52302d'));
        $row->setHeight(70);

        $oCell = $row->nextCell();
        $oCell->createTextRun('logo')->getFont()->setBold(true);
        $oCell->getBorders()->getBottom()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getLeft()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getTop()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getRight()->setLineStyle(Border::LINE_NONE);
        $oCell->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $oCell->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $oCell->setWidth(145);
        $oCell = $row->nextCell();
        $oCell->createTextRun(' ملف رقم - تقرير خبرة قضائية ')->getFont()->setSize(12)->setColor(new Color('ffffff'));
        $oCell->getBorders()->getBottom()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getLeft()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getTop()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getRight()->setLineStyle(Border::LINE_NONE);
        $oCell->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $oCell->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $oCell->setWidth(500);
        $oCell = $row->nextCell();
        $oCell->createTextRun('logo')->getFont()->setBold(true);
        $oCell->getBorders()->getBottom()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getLeft()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getTop()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getRight()->setLineStyle(Border::LINE_NONE);
        $oCell->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $oCell->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $oCell->setWidth(145);
    }

    /**



     * creer footer de chaque slide

     */
    public function createFooterReport($objPHPPowerPoint,$Slide){

        $shapeFooter = $Slide->createTableShape(2);
        $shapeFooter->setHeight(50);
        $shapeFooter->setWidth(789);
        // Modifier la position du shape
        $shapeFooter->setOffsetX(0);
        $shapeFooter->setOffsetY(1055);



        // Add row

        $row = $shapeFooter->createRow();
        $row->getFill()
            ->setFillType(Fill::FILL_GRADIENT_LINEAR)
            ->setRotation(90)->setStartColor(new Color('FF52302d'))
            ->setEndColor(new Color('FF52302d'));
        $row->setHeight(50);


        $oCell = $row->nextCell();
        $oCell->createTextRun('الخبير محمد لازم')->getFont()->setSize(12)->setColor(new Color('ffffff'));
        $oCell->getBorders()->getBottom()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getLeft()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getTop()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getRight()->setLineStyle(Border::LINE_NONE);
        $oCell->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $oCell->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $oCell->getActiveParagraph()->getAlignment()->setMarginLeft(20);




        $oCell = $row->nextCell();
        $oCell->createTextRun(''.($objPHPPowerPoint->getIndex($Slide)+1))->getFont()->setSize(12)->setColor(new Color('ffffff'));
        $oCell->getBorders()->getBottom()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getLeft()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getTop()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getRight()->setLineStyle(Border::LINE_NONE);
        $oCell->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $oCell->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $oCell->getActiveParagraph()->getAlignment()->setMarginRight(35);

    }

    public function addTitle($slide,$offsetY,$title){


        $shapeTile = $slide->createTableShape(3);
        $shapeTile->setHeight(70);
        $shapeTile->setWidth(720);
        // Modifier la position du shape
        $shapeTile->setOffsetX(0);
        $shapeTile->setOffsetY($offsetY);


        // Add row

        $row = $shapeTile->createRow();
        $row->setHeight(40);

        $oCell = $row->nextCell();



        $oCell->createTextRun( htmlspecialchars($title, ENT_COMPAT, 'UTF-8'), array('rtl' => true))->getFont()->setBold(true)->setSize(16)->setColor(new Color( 'FF52302d' ));;
        $oCell->getBorders()->getBottom()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getLeft()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getTop()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getRight()->setLineStyle(Border::LINE_NONE);
        $oCell->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $oCell->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $oCell->setWidth(660);

        $oCell = $row->nextCell();
        $oCell->getBorders()->getBottom()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getLeft()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getTop()->setLineStyle(Border::LINE_NONE);
        $oCell->getBorders()->getRight()->setLineStyle(Border::LINE_NONE);
        $oCell->setWidth(10);

        $oCell = $row->nextCell();
        $oCell->createTextRun('2-1')->getFont()->setBold(true)->setSize(16);
        $oCell->getBorders()->getBottom()->setLineWidth(2)->setColor(new Color('FF52302d'));
        $oCell->getBorders()->getLeft()->setLineWidth(2)->setColor(new Color('FF52302d'));
        $oCell->getBorders()->getTop()->setLineWidth(2)->setColor(new Color('FF52302d'));
        $oCell->getBorders()->getRight()->setLineWidth(2)->setColor(new Color('FF52302d'));
        $oCell->getActiveParagraph()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $oCell->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $oCell->setWidth(50);
        $oCell->getFill()
            ->setFillType(Fill::FILL_GRADIENT_LINEAR)
            ->setRotation(270)
            ->setStartColor(new Color('FFc2994c'))
            ->setEndColor(new Color('FFc2994c'));

    }



    /**



     * @return la list des dossiers

     */

    public function getDossier(){

        $a=[];

        $dossiers=Dossier::where('deposer','0')->paginate(10);;





        foreach ($dossiers as $k=>$dossier){

            $jugements=Jugement::where('dossiers_num_dossier',$dossier->num_dossier)->get();

            foreach ($jugements as $jugement) {

//

                $convocation = Convocation::where('jugements_num_jugement', $jugement->num_jugement)->where('jugements_dossiers_num_dossier', $jugement->dossiers_num_dossier)->where('jugements_tribunals_id_tribunal', $jugement->tribunals_id_tribunal)->first();

                if(!empty($convocation)) {

                    if ($convocation->date_convocation != null && $convocation->lieu_convocation != null) {

                        $personnel = Personnel::where('id_personnel', $dossier->personnels_id_personnel)->first();

                        $a[$k]['num_dossier'] = $dossier->num_dossier;

                        $a[$k]['nom_juge'] = $jugement->nom_juge;

                        $a[$k]['date_arrivee'] = $jugement->date_arrivee;

                        $a[$k]['duree_jugement'] = $jugement->duree_jugement;

                        $a[$k]['date_jugement'] = date('d/m/Y',strtotime($convocation->date_convocation));



                        if ($jugement->date_depot == null) {

                            $q = Carbon::createFromFormat('d/m/Y', $jugement->date_arrivee);



                            $date = Carbon::parse($q)->addDay($jugement->duree_jugement);



                            $a[$k]['date_depot'] = date('d/m/Y', strtotime($date));

                            $jugement->date_depot=$a[$k]['date_depot'];

                            $jugement->update();


                        } else {

                            $a[$k]['date_depot'] = $jugement->date_depot;;

                        }



                        $a[$k]['prix_expertise'] = $jugement->prix_expertise;

                        // $date1 = date_create(date('Y-m-d', strtotime($jugement->date_depot)));

                        // $date2 = date_create(date('Y-m-d'));

                        // $date1=Carbon::createFromFormat('d-m-Y',$jugement->date_depot);

                        $date1 = Carbon::createFromFormat('d/m/Y', $a[$k]['date_depot']);

                        $d = Carbon::parse($date1);



                        $now = Carbon::now();



                        if(strtotime($now)>strtotime($d)){

                            $a[$k]['etat_dossier'] = $d->diffInDays($now)*(-1);

                        }else{

                            $a[$k]['etat_dossier'] = $d->diffInDays($now);

                        }

                        $a[$k]['personnel'] = $personnel->name;

                        $a[$k]['num_jugement'] = $jugement->num_jugement;

                        $a[$k]['tribunals_id_tribunal'] = $jugement->tribunals_id_tribunal;

                        if ($jugement->duree_prolongement != null) {

                            $a[$k]['duree_prolongement'] = $jugement->duree_prolongement;

                        } else {

                            $a[$k]['duree_prolongement'] = null;

                        }

                        if ($jugement->declaration != null) {

                            $a[$k]['declaration'] = $jugement->declaration;

                        } else {

                            $a[$k]['declaration'] = null;

                        }

                        if ($jugement->date_repanse != null) {

                            $a[$k]['date_repanse'] = $jugement->date_repanse;

                        } else {

                            $a[$k]['date_repanse'] = null;

                        }
                        if ($jugement->diff_date_rep_sess != null) {
                            $a[$k]['diff_date'] = $jugement->diff_date_rep_sess;
                        }else{
                            $a[$k]['diff_date'] = null;
                        }

                    }

                }



            }

        }

        return view('admin.dossier',compact('a','dossiers'));

    }



    public function destroy($id){

        // $convocation=Convocation::where('jugements_num_jugement',$id)->first();

        // $convocation->delete();

        // $immobiliers_natures=Immobiliers_natures::where('immobiliers_jugements_num_jugement',$id)->get();

        //  foreach ($immobiliers_natures as $immobiliers_nature){

        //      $immobiliers_nature->delete();

        //  }

        // $immobiliers=Immobilier::where('jugements_num_jugement',$id)->get();

        // foreach ($immobiliers as $immobilier){

        //     $immobilier->delete();

        // }

        // $jugements_autres=Jugements_autres::where('jugements_num_jugement',$id)->get();

        // foreach ($jugements_autres as $jugements_autre){

        //     $jugements_autre->delete();

        // }

        // $jugements_defendeurs=Jugements_defendeurs::where('jugements_num_jugement',$id)->get();

        // foreach ($jugements_defendeurs as $jugements_defendeur){

        //     $jugements_defendeur->delete();

        // }

        // $jugements_procureurs=Jugements_procureurs::where('jugements_num_jugement',$id)->get();

        // foreach ($jugements_procureurs as $jugements_procureur){

        //     $jugements_procureur->delete();

        // }

        // $tribunal_villes=Tribunals_villes::where('jugement_id',$id)->first();

        // $tribunal_villes->delete();

        // $jugement=Jugement::where('num_jugement',$id)->first();

        // $jugement->delete();

        // return redirect()->route('dossier.getDossier')->with('success','item was deliting ');

        $convocation=Convocation::where('jugements_num_jugement',$id)->first();

        $convocation->delete();

        $immobiliers_natures=Immobiliers_natures::where('immobiliers_jugements_num_jugement',$id)->get();

        foreach ($immobiliers_natures as $immobiliers_nature){

            $immobiliers_nature->delete();

        }
//

        $immobiliers=Immobilier::where('jugements_num_jugement',$id)->get();
        foreach($immobiliers as $i){
            Procureurs_immobiliers::where('id_immobilier',$i->num_immobilier)->delete();
        }
        foreach($immobiliers as $i){
            Defendeurs_immobiliers::where('id_immobilier',$i->num_immobilier)->delete();
        }
        foreach($immobiliers as $i) {
            $batiments = Batiment::where('immobiliers_num_immobilier',$i->num_immobilier)->get();
            foreach ($batiments as $batiment){
                $sous_batiments=Sous_batiment::where('ref_batiment',$batiment->ref_batiment)->get();
                foreach ($sous_batiments as $sb){
                    $sb->delete();
                }
            }
        }
        foreach($immobiliers as $i) {
            $batiments = Batiment::where('immobiliers_num_immobilier',$i->num_immobilier)->get();
            foreach ($batiments as $batiment){
                $batiment->delete();
            }
        }
        $jugement=Jugement::where('num_jugement',$id)->first();
        $dossier=$jugement->dossiers_num_dossier;
        $rcs=Reports_contents::where('num_dossier',$dossier)->get();
        foreach($rcs as $rc){
            $rci=Reports_contents_imgs::where('id_report_content',$rc->id)->get();
            foreach ($rci as $v){
                $v->delete();
            }
        }
        foreach($rcs as $rc){
            $rc->delete();
        }
        foreach($immobiliers as $i) {
            $arrivants=Arrivant::where('id_immobilier',$i->num_immobilier)->get();
            foreach($arrivants as $arrivant){
                $arrivant->delete();
            }
        }
//


        $jugements_autres=Jugements_autres::where('jugements_num_jugement',$id)->get();

        foreach ($jugements_autres as $jugements_autre){

            $autre_ids[]=$jugements_autre->autres_id_autre;

            $jugements_autre->delete();

            foreach ($autre_ids as $autre_id) {

                $autre = Autre::where('id_autre',$autre_id)->first();

                if(!empty($autre)){

                    $autre->delete();

                }

            }

        }

        $jugements_defendeurs=Jugements_defendeurs::where('jugements_num_jugement',$id)->get();

        foreach ($jugements_defendeurs as $jugements_defendeur){

            $defendeurs_avocats=Defendeurs_avocats::where('defendeurs_id_defendeur',$jugements_defendeur->defendeurs_id_defendeur)->get();

            if(!empty($jugements_defendeur->defendeurs_id_defendeur)) {

                $def_ids[] = $jugements_defendeur->defendeurs_id_defendeur;

            }

            foreach ($defendeurs_avocats as $defendeurs_avocat){

                $defendeurs_avocat->delete();

//                $avocat=Avocat::where('id_avocat',$defendeurs_avocat->avocats_id_avocat)->first();
//
//                $avocat->delete();



            }



            $jugements_defendeur->delete();

            foreach ($def_ids as $def_id){

                $defendeur=Defendeur::where('id_defendeur',$def_id)->first();

                if(!empty($defendeur)) {

                    $defendeur->delete();

                }

            }

        }

        $jugements_procureurs=Jugements_procureurs::where('jugements_num_jugement',$id)->get();

        foreach ($jugements_procureurs as $jugements_procureur){

            $procureurs_avocats=Procureurs_avocats::where('procureurs_id_procureur',$jugements_procureur->procureurs_id_procureur)->get();

            if(!empty($jugements_procureur->procureurs_id_procureur)) {

                $pro_ids[] = $jugements_procureur->procureurs_id_procureur;

            }

            foreach ($procureurs_avocats as $procureurs_avocat){

                $procureurs_avocat->delete();

//                $avocat=Avocat::where('id_avocat',$procureurs_avocat->avocats_id_avocat)->first();
//
//                $avocat->delete();



            }



            $jugements_procureur->delete();

            foreach ($pro_ids as $pro_id){

                $procureur=Procureur::where('id_procureur',$pro_id)->first();

                if(!empty($procureur)) {

                    $procureur->delete();

                }

            }

            $jugements_procureur->delete();

        }

        $tribunal_villes=Tribunals_villes::where('jugement_id',$id)->first();

        $tribunal_villes->delete();
        foreach ($immobiliers as $immobilier){

            $immobilier->delete();

        }
        $jugement=Jugement::where('num_jugement',$id)->first();

        $dossier_id=$jugement->dossiers_num_dossier;

        $jugement->delete();

        $dossier=Dossier::where('num_dossier',$dossier_id)->first();

        if(!empty($dossier)) {

            $dossier->delete();

        }

        return redirect()->route('dossier.getDossier')->with('success','تم حذف الملف بنجاح ');



    }

    /**



     * @return la page de modification d'un dossier

     */

    public function edit($id){

        $jugement=Jugement::where('num_jugement',$id)->first();

        $convocation=Convocation::where('jugements_num_jugement',$id)->first();

        $personnel=Personnel::pluck('name','id_personnel');

        $dossier=Dossier::where('num_dossier',$jugement->dossiers_num_dossier)->first();

        $id_personnel=Personnel::where('id_personnel',$dossier->personnels_id_personnel)->first();

        return view('admin.edit',compact('jugement','convocation','personnel','id_personnel'));

    }

    public function prolongement(Request $request,$id){

        $this->validate($request,[
            'duree_prolongement_jugement'=>'required'
        ]);
        $jugement = Jugement::where('num_jugement', $id)->first();
        $q = Carbon::createFromFormat('d/m/Y', $jugement->date_depot);
        $date = Carbon::parse($q)->addDay($request->duree_prolongement_jugement);
        $tarikh_idaa = date('d/m/Y', strtotime($date));
        $jugement->date_depot = $tarikh_idaa;
        $jugement->duree_prolongement = $request->duree_prolongement_jugement;
        $jugement->update();

        return back()->with('success','تمت الإضافة');
    }

    public function declaration(Request $request,$id){
        $this->validate($request,[
            'date_declaration'=>'required'
        ]);
        $jugement = Jugement::where('num_jugement', $id)->first();
        $date = Carbon::createFromFormat('d/m/Y', $request->date_declaration);
        $date = date('d/m/Y', strtotime($date));
        $jugement->declaration=$date;
        $jugement->update();
        return back()->with('success','تمت الإضافة');

    }

    public function confirmer(Request $request,$id){

        $this->validate($request,[
            'date_seance'=>'required',
            'date_repanse_convocation'=>'required'
        ]);
        $jugement = Jugement::where('num_jugement', $id)->first();
        $date_s = Carbon::createFromFormat('d/m/Y', $request->date_seance);
        $date_repanse = Carbon::createFromFormat('d/m/Y', $request->date_repanse_convocation);
        $date_diff = Carbon::parse($date_repanse)->diffInDays($date_s);
        $date_repanse=date('d/m/Y', strtotime($date_repanse));
        $jugement->date_repanse=$date_repanse;
        $jugement->diff_date_rep_sess=$date_diff;
        $jugement->update();

        return back()->with('success','تمت الإضافة');

    }



    /**



     * Modifier un enregistrement de dossier

     */

    public function update(Request $request,$id){

        $jugement=Jugement::where('num_jugement',$id)->first();



        $jugement->nom_juge=$request->nom_juge;

        $jugement->date_arrivee=$request->date_arrivee;

        $jugement->duree_prolongement=$request->duree_jugement;



        if($request->date_repanse==null && $request->duree_prolongement==null){

            $c=Carbon::createFromFormat('d/m/Y',$request->date_arrivee);

            $date2 = Carbon::parse($c)->addDay($request->duree_jugement);

            $jugement->date_depot=date('d/m/Y', strtotime($date2));



        }

        if($request->date_repanse==null && $request->duree_prolongement!=null){

            $duree=$request->duree_jugement+$request->duree_prolongement;

            $d=Carbon::createFromFormat('d/m/Y',$request->date_arrivee);

            $date3 = Carbon::parse($d)->addDay($duree);

            $jugement->date_depot=date('d/m/Y', strtotime($date3));



        }

        if($request->date_repanse!=null && $request->duree_prolongement==null){

            $e=Carbon::createFromFormat('d/m/Y',$request->date_repanse);

            $date4 = Carbon::parse($e)->addDay($request->duree_jugement);

            $jugement->date_depot=date('d/m/Y', strtotime($date4));



        }

        $jugement->prix_expertise=$request->prix_expertise;

        $jugement->duree_prolongement=$request->duree_prolongement;

        $jugement->declaration=$request->declaration;

        $jugement->date_repanse=$request->date_repanse;

        $jugement->duree_jugement=$request->duree_jugement;

        $jugement->update();

        $convocation=Convocation::where('jugements_num_jugement',$id)->first();

        $convocation->date_convocation=date('d/m/Y', strtotime($request->date_convocation));;

        $convocation->update();

        $dossier=Dossier::where('num_dossier',$jugement->dossiers_num_dossier)->first();

        $dossier->personnels_id_personnel=$request->personnels_id_personnel;

        $dossier->update();

        Session::flash('success','modif c ok');

        return redirect()->route('dossier.getDossier');

    }

    /**



     * imprimer un tableaur excel qui contient la list des dossier

     */

    public function excel(Request $request){

        $a=[];

        $dossiers=Dossier::where('deposer','0')->get();



        $k=0;

        foreach ($dossiers as $dossier) {



            $jugement = Jugement::where('dossiers_num_dossier', $dossier->num_dossier)->first();

//

            if(!empty($jugement)){

                $convocation = Convocation::where('jugements_num_jugement', $jugement->num_jugement)->where('jugements_dossiers_num_dossier', $jugement->dossiers_num_dossier)->where('jugements_tribunals_id_tribunal', $jugement->tribunals_id_tribunal)->first();



                if(!empty($convocation)) {

                    if ($convocation->date_convocation != null && $convocation->lieu_convocation != null) {

                        $k++;

                        $personnel = Personnel::where('id_personnel', $dossier->personnels_id_personnel)->first();

                        $a[$k]['num_dossier'] = $dossier->num_dossier;

                        $a[$k]['nom_juge'] = $jugement->nom_juge;

                        $a[$k]['date_arrivee'] = $jugement->date_arrivee;

                        $a[$k]['duree_jugement'] = $jugement->duree_jugement;

                        $a[$k]['date_jugement'] = $convocation->date_convocation;

                        if ($jugement->date_depot == null) {

                            $q = Carbon::createFromFormat('d/m/Y', $jugement->date_arrivee);

                            $date = Carbon::parse($q)->addDay($jugement->duree_jugement);

                            $a[$k]['date_depot'] = date('d-m-Y', strtotime($date));

                        } else {

                            $a[$k]['date_depot'] = $jugement->date_depot;;

                        }

                        $a[$k]['prix_expertise'] = $jugement->prix_expertise;

                        $date1 = date_create(date('Y-m-d', strtotime($jugement->date_depot)));

                        $date2 = date_create(date('Y-m-d'));

                        $diff = date_diff($date2, $date1);

                        $a[$k]['etat_dossier'] = $diff->format("%R%a days");

                        $a[$k]['personnel'] = $personnel->name;

                        $a[$k]['num_jugement'] = $jugement->num_jugement;

                        $a[$k]['tribunals_id_tribunal'] = $jugement->tribunals_id_tribunal;

                        if ($jugement->duree_prolongement != null) {

                            $a[$k]['duree_prolongement'] = $jugement->duree_prolongement;

                        } else {

                            $a[$k]['duree_prolongement'] = null;

                        }

                        if ($jugement->declaration != null) {

                            $a[$k]['declaration'] = $jugement->declaration;

                        } else {

                            $a[$k]['declaration'] = null;

                        }

                        if ($jugement->date_repanse != null) {

                            $a[$k]['date_repanse'] = $jugement->date_repanse;

                        } else {

                            $a[$k]['date_repanse'] = null;

                        }



                    }

                }

            }

        }



        $objPHPExcel = new \PHPExcel();

        // print_r($objPHPExcel);die();

        $objPHPExcel->setActiveSheetIndex(0);









        $objPHPExcel->getActiveSheet()

            ->getStyle('A1:K1')

            ->getFill()

            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)

            ->getStartColor()

            ->setARGB('FFFFFF00');





//        $data = $this->surveymodel->getDataLaporanBrand('rr','rr','rr');

        // print_r($data);die();

        $i = 1;



        // print_r($value["Score"]);print_r($value['TotalData']);die();

        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, 'المكلف باللف');

        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, 'الجواب على البيان الاخباري');

        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, 'بيان اخباري');

        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, 'طلب التمديد');

        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, 'الاتعاب');

        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, 'تاريخ الايداع');

        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, 'تاريخ الخبرة');

        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, 'مدة الانجاز');

        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, 'تاريخ التوصل');

        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, 'القاضي المقرر');

        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, 'رقم الملف');





        foreach ($a as $k=>$v){

            $k=$k+1;

            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$k, $v['personnel']);

            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$k, $v['date_repanse']);

            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$k, $v['declaration']);

            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$k, $v['duree_prolongement']);

            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$k, $v['prix_expertise']);

            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$k, $v['date_depot']);

            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$k, $v['date_jugement']);

            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$k, $v['duree_jugement']);

            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$k, $v['date_arrivee']);

            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$k, $v['nom_juge']);

            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$k, $v['num_dossier']);

        }





        // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file

        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);

        //



        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment;filename="Filename.xlsx"');

        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");

        //  ob_end_clean();

        $objWriter->save('php://output');

        exit;

        // Write file to the browser







    }

    /**



     * faire une recherche selon numero de dossier

     */

    public function search(){



        $a=[];

        $dossiers=Dossier::where('num_dossier','LIKE',$_GET['search'].'%')->where('deposer','0')->get();







        if(!empty($dossiers)) {

            foreach ($dossiers as $k => $dossier) {



                $jugement = Jugement::where('dossiers_num_dossier', $dossier->num_dossier)->first();

                if (!empty($jugement)) {

                    $convocation = Convocation::where('jugements_num_jugement', $jugement->num_jugement)->where('jugements_dossiers_num_dossier', $jugement->dossiers_num_dossier)->where('jugements_tribunals_id_tribunal', $jugement->tribunals_id_tribunal)->first();





                    if (!empty($convocation)) {

                        if ($convocation->date_convocation != null && $convocation->lieu_convocation != null) {

                            $personnel = Personnel::where('id_personnel', $dossier->personnels_id_personnel)->first();

                            $a[$k]['num_dossier'] = $dossier->num_dossier;

                            $a[$k]['nom_juge'] = $jugement->nom_juge;

                            $a[$k]['date_arrivee'] = $jugement->date_arrivee;

                            $a[$k]['duree_jugement'] = $jugement->duree_jugement;

                            $a[$k]['date_jugement'] = $convocation->date_convocation;



                            if ($jugement->date_depot == null) {

                                $q = Carbon::createFromFormat('d/m/Y', $jugement->date_arrivee);



                                $date = Carbon::parse($q)->addDay($jugement->duree_jugement);



                                $a[$k]['date_depot'] = date('d/m/Y', strtotime($date));



                            } else {

                                $a[$k]['date_depot'] = $jugement->date_depot;

                            }



                            $a[$k]['prix_expertise'] = $jugement->prix_expertise;

                            // $date1 = date_create(date('Y-m-d', strtotime($jugement->date_depot)));

                            // $date2 = date_create(date('Y-m-d'));

                            // $date1=Carbon::createFromFormat('d-m-Y',$jugement->date_depot);

                            $date1 = Carbon::createFromFormat('d/m/Y', $a[$k]['date_depot']);

                            $d = Carbon::parse($date1);



                            $now = Carbon::now();

                            $a[$k]['etat_dossier'] = $d->diffInDays($now);



                            $a[$k]['personnel'] = $personnel->name;

                            $a[$k]['num_jugement'] = $jugement->num_jugement;

                            $a[$k]['tribunals_id_tribunal'] = $jugement->tribunals_id_tribunal;

                            if ($jugement->duree_prolongement != null) {

                                $a[$k]['duree_prolongement'] = $jugement->duree_prolongement;

                            } else {

                                $a[$k]['duree_prolongement'] = null;

                            }

                            if ($jugement->declaration != null) {

                                $a[$k]['declaration'] = $jugement->declaration;

                            } else {

                                $a[$k]['declaration'] = null;

                            }

                            if ($jugement->date_repanse != null) {

                                $a[$k]['date_repanse'] = $jugement->date_repanse;

                            } else {

                                $a[$k]['date_repanse'] = null;

                            }



                        }



                    }

                }

            }

            $r = $a;



            foreach ($r as $i => $a) {



                ?>

                <tr>

                    <td><?= $a['num_dossier'] ?></td>

                    <td><?= $a['nom_juge'] ?></td>

                    <td><?= $a['date_arrivee'] ?></td>

                    <td><?= $a['duree_jugement'] ?></td>

                    <td><?= $a['date_jugement'] ?></td>

                    <td id="d_depot"><?= $a['date_depot'] ?></td>

                    <td><?= $a['prix_expertise'] ?></td>

                    <td id="dp">

                        <?php if ($a['duree_prolongement'] == null) { ?>

                            <input type="checkbox" name="dpj" id="check" style="float: left;">  <input

                                nam="duree_prolongement_jugement" type="text" class="form-control" id="plgt">

                        <?php } else { ?>

                            <?= $a['duree_prolongement'] ?>

                        <?php } ?>

                    </td>

                    <td id="date_sent">

                        <?php if ($a['declaration'] == null) { ?>

                            <input type="checkbox" name="Communique" id="check1" style="float: left;"> <input

                                nam="date_envoye_convocation" type="text" class="form-control plgt1"

                                id="picher<?= $i ?>">

                        <?php } else { ?>

                            <?= $a['declaration'] ?>

                        <?php } ?>

                    </td>

                    <td id="scolor">

                        <?php if ($a['etat_dossier'] >= 10 && $a['declaration'] == null) { ?>

                            <span class="badge badge-success badge-pill ">&nbsp;</span>

                        <?php } else if ($a['etat_dossier'] > 5 && $a['etat_dossier'] < 10 && $a['declaration'] == null) { ?>

                            <span class="badge badge-warning badge-pill ">&nbsp;</span>

                        <?php } else if ($a['declaration'] != null) { ?>

                            <span class="badge badge-default badge-pill " style="background: yellow">&nbsp;</span>

                        <?php } else if ($a['etat_dossier'] < 5 && $a['declaration'] == null) { ?>

                            <span class="badge badge-danger badge-pill ">&nbsp;</span>



                        <?php } ?>



                    </td>

                    <td id="date_respanse">

                        <?php if ($a['date_repanse'] == null) { ?>

                            <input type="checkbox" name="Communique" id="check2" style="float: left;"> <input

                                nam="date_repanse_convocation" type="text" class="form-control plgt2"

                                id="picker1<?= $i ?>">

                        <?php } else { ?>

                            <?= $a['date_repanse'] ?>

                        <?php } ?>

                    </td>

                    <td><?= $a['personnel'] ?></td>

                    <td>

                        <form method="POST" action="/dossier/imprimerFeuile" accept-charset="UTF-8" id="imprimForm1">

                            <?=csrf_field()?>

                            <input type="hidden" name="num_jugement" value="<?= $a['num_jugement'] ?>">

                            <input type="hidden" name="num_dossier" value="<?= $a['num_dossier'] ?>">

                            <input type="hidden" name="num_idtribunal" value="<?= $a['tribunals_id_tribunal'] ?>">

                            <button type="submit"  class="btn btn-default" id="impF"  ><i  class="fa fa-print" aria-hidden="true" style="position: relative;left:6px;"></i></button>





                        </form>

                    </td>

                    <td>

                        <form method="POST" action="/dossier/deposer" accept-charset="UTF-8">

                            <?=csrf_field()?>

                            <input type="hidden" name="num_jugement" value="<?= $a['num_jugement'] ?>">

                            <input type="hidden" name="num_dossier" value="<?= $a['num_dossier'] ?>">

                            <input type="hidden" name="num_idtribunal" value="<?= $a['tribunals_id_tribunal'] ?>">

                            <button type="submit" class="btn btn-danger"  id="deposer" style="width:6px;"><i class="fa fa-hourglass-end" aria-hidden="true" style="position: relative;left:17px;"></i></button>

                        </form>

                    </td>

                    <td class="row">

                        <form method="POST">

                            <input type="hidden" name="_method" value="DELETE">

                            <a href="/dossier/delete/<?= $a['num_jugement'] ?>" id="delete"><i

                                    class="fa fa-trash"

                                    aria-hidden="true"

                                    style="color: red;"></i></a>

                        </form>&nbsp;<a href="/dossier/<?= $a['num_jugement'] ?>/edit"><i

                                class="fa fa-pencil-square" aria-hidden="true"></i></a>&nbsp;



                        <a href="/dossier/<?= $a['num_jugement'] ?>/confirmer"

                           style="color: forestgreen;"

                           id="confirm"><i class="fa fa-check-circle" aria-hidden="true"></i></a>&nbsp;





                        <form method="POST" action="/imprimer" accept-charset="UTF-8"

                              id="imprimForm">

                            <?=csrf_field()?>

                            <input type="hidden" name="num_jugement" value="<?= $a['num_jugement'] ?>">

                            <input type="hidden" name="num_dossier" value="<?= $a['num_dossier'] ?>">

                            <input type="hidden" name="num_idtribunal" value="<?= $a['tribunals_id_tribunal'] ?>">



                            <span type="submit"  style="width: 0px;height:0px;padding: 0;margin: 0;" id="submit"><i class="fa fa-file-word-o fa" aria-hidden="true" style="color:black;"></i></span>



                        </form>





                    </td>

                </tr>



                <?php



            }



        }



    }

    /**



     * imprime une convocation

     */



    public function imprimerFeuile(Request $request){

        $jugement=Jugement::where('num_jugement',$request->num_jugement)->where('dossiers_num_dossier',$request->num_dossier)->where('tribunals_id_tribunal',$request->num_idtribunal)->first();

        $tribunal_ville=Tribunals_villes::where('jugement_id',$jugement->num_jugement)->first();

        $tribunal=Tribunal::where('id_tribunal',$tribunal_ville->id_tribunal)->first();

        $ville=Villes::where('id_ville',$tribunal_ville->id_ville)->first();



        $convocation=Convocation::where('jugements_num_jugement',$request->num_jugement)->where('jugements_dossiers_num_dossier',$request->num_dossier)->where('jugements_tribunals_id_tribunal',$request->num_idtribunal)->first();

        $datec=date('d/m/Y H:i', strtotime($convocation->date_convocation));

        $dateconv=explode(' ',$datec);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $phpWord->addParagraphStyle('My Style', array(

                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(6))

        );

        $section = $phpWord->addSection();

        $sectionStyle = $section->getStyle();

// half inch left margin

        $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(11));

        $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(10));

        $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(18));

        $sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(10));

// 2 cm right margin

//        $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(2));

//        $sectionStyle = array(

//            'marginTop' => 100,

//            'marginLeft'=>1000

//        );



//        $phpWord->setDefaultFontName('Times New Roman');

        $fancyTableStyleName = 'Fancy Table';

        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 40, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);

        $fancyTableFirstRowStyle1 = array('borderColor' => '000000');

        $fancyTableCellStyle = array('valign' => 'center');

        $fancyTableFontStyle = array('bold' => true);

        $section->addText(htmlspecialchars('الخبير محمد لازم', ENT_COMPAT, 'UTF-8'), array('size'=>22,'bold'=>true,'name'=>'Times New Roman','marginTop'=>1),array("align" => "right",'space' => array('line' => 200)));

        $section->addText('خبير قضائي محلف لدى محكمة الاستئناف بالدار البيضاء', array('size'=>10,'bold'=>true,'name'=>'Times New Roman'),array("align" => "right",'space' => array('line' => 220)));;

//       $l->setFontStyle(array('rtl' => true));

        $section->addText(htmlspecialchars(' لندن --RICS عضو في المنظمة الدولية للخبراء العقاريين -  خبير دولي في العقار', ENT_COMPAT, 'UTF-8'), array('size'=>10,'bold'=>true,'name'=>'Times New Roman'),array("align" => "right",'space' => array('line' => 200,'rule' => 'exact')));;

        $section->addText(htmlspecialchars('مهندس الدولة في الهندسة المدنية                                      ', ENT_COMPAT, 'UTF-8'), array('size'=>10,'bold'=>true,'name'=>'Times New Roman'),array("align" => "right",'space' => array('line' => 220)));;

        $section->addText(htmlspecialchars("« DCIS / DCES / DCIE » خبير معتمد في مراكز البيانات", ENT_COMPAT, 'UTF-8'), array('size'=>10,'bold'=>true,'name'=>'Times New Roman'),array("align" => "right",'space' => array('line' => 200)));;

        $section->addText(htmlspecialchars('X-Collège Polytechnique de Paris - ماجستير في تسيير المشاريع ', ENT_COMPAT, 'UTF-8'), array('size'=>10,'bold'=>true,'name'=>'Times New Roman'),array("align" => "right",'space' => array('line' => 200)));;

        $section->addText(htmlspecialchars(' دبلوم الدراسات الاقتصادية والقانونية المطبقة في البناء والسكنى', ENT_COMPAT, 'UTF-8'), array('size'=>10,'bold'=>true,'name'=>'Times New Roman'),array("align" => "right",'space' => array('line' => 200)));;

        $section->addText(htmlspecialchars('  05 22 22 55 66 :الهاتف ', ENT_COMPAT, 'UTF-8'), array('size'=>12,'bold'=>true,'name'=>'arial'),array("align" => "right",'space' => array('line' => 200)));;

        $section->addText(htmlspecialchars('ورقة الحضور والتصريحات', ENT_COMPAT, 'UTF-8'), array('size'=>22,'bold'=>true,'name'=>'Times New Roman','underline' => 'single'),array("align" => "center"));;

        $section->addText(htmlspecialchars('المراجع', ENT_COMPAT, 'UTF-8'), array('size'=>18,'bold'=>true,'name'=>'Times New Roman','underline' => 'single'),array("align" => "right"));;

        if($ville->nom_ville=="الدار البيضاء"){
         if($tribunal->nom_tribunal=='محكمة الاستئناف'){
             $section->addText(htmlspecialchars("$tribunal->nom_tribunal"." بالدار البيضاء", ENT_COMPAT, 'UTF-8'), array('size'=>16,'bold'=>true,'name'=>'Times New Roman'),array("align" => "right"));;

         }else{
             $section->addText(htmlspecialchars("$tribunal->nom_tribunal"." المدنية بالدار البيضاء", ENT_COMPAT, 'UTF-8'), array('size'=>16,'bold'=>true,'name'=>'Times New Roman'),array("align" => "right"));;

         }

        }else{
            $section->addText(htmlspecialchars("$tribunal->nom_tribunal "."ب"."$ville->nom_ville ", ENT_COMPAT, 'UTF-8'), array('size'=>16,'bold'=>true,'name'=>'Times New Roman'),array("align" => "right"));;

        }

        $section->addText(htmlspecialchars("      $request->num_dossier         : ملف رقم     -", ENT_COMPAT, 'UTF-8'), array('size'=>14,'bold'=>true,'name'=>'Times New Roman'),array("align" => "right"));;

        $section->addText(htmlspecialchars("  $request->num_jugement        : حكم عدد    -  ", ENT_COMPAT, 'UTF-8'), array('size'=>14,'bold'=>true,'name'=>'Times New Roman'),array("align" => "right"));;

        $section->addText(htmlspecialchars("  ".date('d/m/Y', strtotime($jugement->date_jugement))."          :     بتاريخ  - ", ENT_COMPAT, 'UTF-8'), array('size'=>14,'bold'=>true,'name'=>'Times New Roman'),array("align" => "right"));;
        $heure_conv=$convocation->heure_convocation;
        $section->addText(htmlspecialchars(" . $heure_conv. $dateconv[1]  على الساعة   $dateconv[0]  : يوم    ", ENT_COMPAT, 'UTF-8'), array('size'=>16,'bold'=>true,'name'=>'Times New Roman'),array("align" => "center"));;



        $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle1);

        $table = $section->addTable($fancyTableStyleName);

        $table->addRow(900);

        $table->addCell(2000, $fancyTableCellStyle)->addText(htmlspecialchars('توقيعه', ENT_COMPAT, 'UTF-8'), array('size'=>14,'bold'=>true,'name'=>'Times New Roman'),array("align" => "center"), $fancyTableFontStyle);

        $table->addCell(2000, $fancyTableCellStyle)->addText(htmlspecialchars('تصريحاته  ', ENT_COMPAT, 'UTF-8'), array('size'=>14,'bold'=>true,'name'=>'Times New Roman'),array("align" => "center"), $fancyTableFontStyle);

        $table->addCell(2200, $fancyTableCellStyle)->addText(htmlspecialchars('ساعة حضوره', ENT_COMPAT, 'UTF-8'), array('size'=>14,'bold'=>true,'name'=>'Times New Roman'),array("align" => "center"), $fancyTableFontStyle);

        $table->addCell(2000, $fancyTableCellStyle)->addText(htmlspecialchars('صفته  ', ENT_COMPAT, 'UTF-8'), array('size'=>14,'bold'=>true,'name'=>'Times New Roman'),array("align" => "center"), $fancyTableFontStyle);

        $table->addCell(2000, $fancyTableCellStyle)->addText(htmlspecialchars('تعريفه

         N° CIN  ', ENT_COMPAT, 'UTF-8'), array('size'=>14,'bold'=>true,'name'=>'Times New Roman'),array("align" => "center"), $fancyTableFontStyle);

        $table->addCell(2000, $fancyTableCellStyle)->addText(htmlspecialchars('الاسم العائلي والشخصي  ', ENT_COMPAT, 'UTF-8'), array('size'=>14,'bold'=>true,'name'=>'Times New Roman'),array("align" => "center"), $fancyTableFontStyle);

        $table->addRow(5500);

        $table->addCell(2000)->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true), array("align" => "right"));

        $table->addCell(4000)->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true), array("align" => "right"));

        $table->addCell(2000)->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true), array("align" => "right"));

        $table->addCell(2000)->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true), array("align" => "right"));

        $table->addCell(2000)->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true), array("align" => "right"));

        $table->addCell(4000)->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('rtl' => true), array("align" => "right"));

        $section->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true,'bold' => true,'size'=>16,'underline' => 'single'),array("align" => "right"));;

        $section->addText(htmlspecialchars("ملاحظات: ", ENT_COMPAT, 'UTF-8'), array('rtl' => true,'bold' => true,'size'=>16,'underline' => 'single'),array("align" => "right"));;















//            $file = 'HelloWorld.'.$key.'.docx';

        header("Content-Description: File Transfer");

        header('Content-Disposition: attachment; filename=feuille.docx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        header('Content-Transfer-Encoding: binary');

        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

        header('Expires: 0');

        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        $xmlWriter->save('php://output');

    }

    /**



     * imprime un tableaur excel qui contient la list des dossier deposer

     */



    public function excelDeposer(Request $request){

        $a=[];

        $dossiers=Dossier::where('deposer','1')->get();

        $k=0;

        foreach ($dossiers as $dossier) {



            $jugement = Jugement::where('dossiers_num_dossier', $dossier->num_dossier)->first();

//

            if(!empty($jugement)){

                $convocation = Convocation::where('jugements_num_jugement', $jugement->num_jugement)->where('jugements_dossiers_num_dossier', $jugement->dossiers_num_dossier)->where('jugements_tribunals_id_tribunal', $jugement->tribunals_id_tribunal)->first();



                if(!empty($convocation)) {

                    if ($convocation->date_convocation != null && $convocation->lieu_convocation != null) {

                        $k++;

                        $personnel = Personnel::where('id_personnel', $dossier->personnels_id_personnel)->first();

                        $a[$k]['num_dossier'] = $dossier->num_dossier;

                        $a[$k]['nom_juge'] = $jugement->nom_juge;

                        $a[$k]['date_arrivee'] = $jugement->date_arrivee;

                        $a[$k]['duree_jugement'] = $jugement->duree_jugement;

                        $a[$k]['date_jugement'] = $convocation->date_convocation;

                        if ($jugement->date_depot == null) {

                            $q = Carbon::createFromFormat('d/m/Y', $jugement->date_arrivee);

                            $date = Carbon::parse($q)->addDay($jugement->duree_jugement);

                            $a[$k]['date_depot'] = date('d-m-Y', strtotime($date));

                        } else {

                            $a[$k]['date_depot'] = $jugement->date_depot;;

                        }

                        $a[$k]['prix_expertise'] = $jugement->prix_expertise;

                        $date1 = date_create(date('Y-m-d', strtotime($jugement->date_depot)));

                        $date2 = date_create(date('Y-m-d'));

                        $diff = date_diff($date2, $date1);

                        $a[$k]['etat_dossier'] = $diff->format("%R%a days");

                        $a[$k]['personnel'] = $personnel->name;

                        $a[$k]['num_jugement'] = $jugement->num_jugement;

                        $a[$k]['tribunals_id_tribunal'] = $jugement->tribunals_id_tribunal;

                        if ($jugement->duree_prolongement != null) {

                            $a[$k]['duree_prolongement'] = $jugement->duree_prolongement;

                        } else {

                            $a[$k]['duree_prolongement'] = null;

                        }

                        if ($jugement->declaration != null) {

                            $a[$k]['declaration'] = $jugement->declaration;

                        } else {

                            $a[$k]['declaration'] = null;

                        }

                        if ($jugement->date_repanse != null) {

                            $a[$k]['date_repanse'] = $jugement->date_repanse;

                        } else {

                            $a[$k]['date_repanse'] = null;

                        }



                    }

                }

            }

        }



        $objPHPExcel = new \PHPExcel();

        // print_r($objPHPExcel);die();

        $objPHPExcel->setActiveSheetIndex(0);









        $objPHPExcel->getActiveSheet()

            ->getStyle('A1:K1')

            ->getFill()

            ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)

            ->getStartColor()

            ->setARGB('FFFFFF00');





//        $data = $this->surveymodel->getDataLaporanBrand('rr','rr','rr');

        // print_r($data);die();

        $i = 1;



        // print_r($value["Score"]);print_r($value['TotalData']);die();

        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$i, 'المكلف باللف');

        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$i, 'الجواب على البيان الاخباري');

        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$i, 'بيان اخباري');

        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$i, 'طلب التمديد');

        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$i, 'الاتعاب');

        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$i, 'تاريخ الايداع');

        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$i, 'تاريخ الخبرة');

        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$i, 'مدة الانجاز');

        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$i, 'تاريخ التوصل');

        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$i, 'لقاضي المقرر');

        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$i, 'رقم الملف');





        foreach ($a as $k=>$v){

            $k=$k+1;

            $objPHPExcel->getActiveSheet()->SetCellValue('A'.$k, $v['personnel']);

            $objPHPExcel->getActiveSheet()->SetCellValue('B'.$k, $v['date_repanse']);

            $objPHPExcel->getActiveSheet()->SetCellValue('C'.$k, $v['declaration']);

            $objPHPExcel->getActiveSheet()->SetCellValue('D'.$k, $v['duree_prolongement']);

            $objPHPExcel->getActiveSheet()->SetCellValue('E'.$k, $v['prix_expertise']);

            $objPHPExcel->getActiveSheet()->SetCellValue('F'.$k, $v['date_depot']);

            $objPHPExcel->getActiveSheet()->SetCellValue('G'.$k, $v['date_jugement']);

            $objPHPExcel->getActiveSheet()->SetCellValue('H'.$k, $v['duree_jugement']);

            $objPHPExcel->getActiveSheet()->SetCellValue('I'.$k, $v['date_arrivee']);

            $objPHPExcel->getActiveSheet()->SetCellValue('J'.$k, $v['nom_juge']);

            $objPHPExcel->getActiveSheet()->SetCellValue('K'.$k, $v['num_dossier']);

        }





        // Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file

        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);

        //



        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        header('Content-Disposition: attachment;filename="Filename.xlsx"');

        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");

        // ob_end_clean();

        $objWriter->save('php://output');

        exit;

        // Write file to the browser





    }

    /**



     * @return la list des dossiers deposer

     */



    public function deposerDossier(){

        $a=[];

        $dossiers=Dossier::where('deposer','1')->get();



        foreach ($dossiers as $k=>$dossier){

            $jugements=Jugement::where('dossiers_num_dossier',$dossier->num_dossier)->get();

            foreach ($jugements as $jugement) {

//

                $convocation = Convocation::where('jugements_num_jugement', $jugement->num_jugement)->where('jugements_dossiers_num_dossier', $jugement->dossiers_num_dossier)->where('jugements_tribunals_id_tribunal', $jugement->tribunals_id_tribunal)->first();

                if(!empty($convocation)) {

                    if ($convocation->date_convocation != null && $convocation->lieu_convocation != null) {

                        $personnel = Personnel::where('id_personnel', $dossier->personnels_id_personnel)->first();

                        $a[$k]['num_dossier'] = $dossier->num_dossier;

                        $a[$k]['nom_juge'] = $jugement->nom_juge;

                        $a[$k]['date_arrivee'] = $jugement->date_arrivee;

                        $a[$k]['duree_jugement'] = $jugement->duree_jugement;

                        $a[$k]['date_jugement'] = date('d/m/Y',strtotime($convocation->date_convocation));



                        if ($jugement->date_depot == null) {

                            $q = Carbon::createFromFormat('d/m/Y', $jugement->date_arrivee);



                            $date = Carbon::parse($q)->addDay($jugement->duree_jugement);



                            $a[$k]['date_depot'] = date('d/m/Y', strtotime($date));



                        } else {

                            $a[$k]['date_depot'] = $jugement->date_depot;;

                        }



                        $a[$k]['prix_expertise'] = $jugement->prix_expertise;

                        // $date1 = date_create(date('Y-m-d', strtotime($jugement->date_depot)));

                        // $date2 = date_create(date('Y-m-d'));

                        // $date1=Carbon::createFromFormat('d-m-Y',$jugement->date_depot);

                        $date1 = Carbon::createFromFormat('d/m/Y', $a[$k]['date_depot']);

                        $d = Carbon::parse($date1);



                        $now = Carbon::now();



                        if(strtotime($now)>strtotime($d)){

                            $a[$k]['etat_dossier'] = $d->diffInDays($now)*(-1);

                        }else{

                            $a[$k]['etat_dossier'] = $d->diffInDays($now);

                        }

                        $a[$k]['personnel'] = $personnel->name;

                        $a[$k]['num_jugement'] = $jugement->num_jugement;

                        $a[$k]['tribunals_id_tribunal'] = $jugement->tribunals_id_tribunal;

                        if ($jugement->duree_prolongement != null) {

                            $a[$k]['duree_prolongement'] = $jugement->duree_prolongement;

                        } else {

                            $a[$k]['duree_prolongement'] = null;

                        }

                        if ($jugement->declaration != null) {

                            $a[$k]['declaration'] = $jugement->declaration;

                        } else {

                            $a[$k]['declaration'] = null;

                        }

                        if ($jugement->date_repanse != null) {

                            $a[$k]['date_repanse'] = $jugement->date_repanse;

                        } else {

                            $a[$k]['date_repanse'] = null;

                        }

                    }

                }



            }

        }

        return view('admin.deposerDossier',compact('a'));

    }

    /**



     * fonction pour deposer les dossier

     */



    public function deposer(Request $request){

        $dossier=Dossier::where('num_dossier',$request->num_dossier)->first();

        $dossier->deposer='1';

        $dossier->update();

        return redirect()->route('dossier.getDossier')->with('success',' * لقد تم وضع الملف بنجاح !');

    }



    public function searchDeposer(){



        $a=[];

        $dossiers=Dossier::where('num_dossier','LIKE',$_GET['search'].'%')->where('deposer','1')->get();





        if(!empty($dossiers)) {

            foreach ($dossiers as $k => $dossier) {



                $jugement = Jugement::where('dossiers_num_dossier', $dossier->num_dossier)->first();

                if (!empty($jugement)) {

                    $convocation = Convocation::where('jugements_num_jugement', $jugement->num_jugement)->where('jugements_dossiers_num_dossier', $jugement->dossiers_num_dossier)->where('jugements_tribunals_id_tribunal', $jugement->tribunals_id_tribunal)->first();





                    if (!empty($convocation)) {

                        if ($convocation->date_convocation != null && $convocation->lieu_convocation != null) {

                            $personnel = Personnel::where('id_personnel', $dossier->personnels_id_personnel)->first();

                            $a[$k]['num_dossier'] = $dossier->num_dossier;

                            $a[$k]['nom_juge'] = $jugement->nom_juge;

                            $a[$k]['date_arrivee'] = $jugement->date_arrivee;

                            $a[$k]['duree_jugement'] = $jugement->duree_jugement;

                            $a[$k]['date_jugement'] = date('d/m/Y',strtotime($convocation->date_convocation));



                            if ($jugement->date_depot == null) {

                                $q = Carbon::createFromFormat('d/m/Y', $jugement->date_arrivee);



                                $date = Carbon::parse($q)->addDay($jugement->duree_jugement);



                                $a[$k]['date_depot'] = date('d/m/Y', strtotime($date));



                            } else {

                                $a[$k]['date_depot'] = $jugement->date_depot;

                            }



                            $a[$k]['prix_expertise'] = $jugement->prix_expertise;

                            // $date1 = date_create(date('Y-m-d', strtotime($jugement->date_depot)));

                            // $date2 = date_create(date('Y-m-d'));

                            // $date1=Carbon::createFromFormat('d-m-Y',$jugement->date_depot);

                            $date1 = Carbon::createFromFormat('d/m/Y', $a[$k]['date_depot']);

                            $d = Carbon::parse($date1);



                            $now = Carbon::now();

                            $a[$k]['etat_dossier'] = $d->diffInDays($now);



                            $a[$k]['personnel'] = $personnel->name;

                            $a[$k]['num_jugement'] = $jugement->num_jugement;

                            $a[$k]['tribunals_id_tribunal'] = $jugement->tribunals_id_tribunal;

                            if ($jugement->duree_prolongement != null) {

                                $a[$k]['duree_prolongement'] = $jugement->duree_prolongement;

                            } else {

                                $a[$k]['duree_prolongement'] = null;

                            }

                            if ($jugement->declaration != null) {

                                $a[$k]['declaration'] = $jugement->declaration;

                            } else {

                                $a[$k]['declaration'] = null;

                            }

                            if ($jugement->date_repanse != null) {

                                $a[$k]['date_repanse'] = $jugement->date_repanse;

                            } else {

                                $a[$k]['date_repanse'] = null;

                            }



                        }



                    }

                }

            }

            $r = $a;



            foreach ($r as $i => $a) {



                ?>

                <tr>

                    <td><?= $a['num_dossier'] ?></td>

                    <td><?= $a['nom_juge'] ?></td>

                    <td><?= $a['date_arrivee'] ?></td>

                    <td><?= $a['duree_jugement'] ?></td>

                    <td><?= $a['date_jugement'] ?></td>

                    <td id="d_depot"><?= $a['date_depot'] ?></td>

                    <td><?= $a['prix_expertise'] ?></td>

                    <td id="dp">

                        <?php if ($a['duree_prolongement'] == null) { ?>

                            <input type="checkbox" name="dpj" id="check" style="float: left;">  <input

                                nam="duree_prolongement_jugement" type="text" class="form-control" id="plgt">

                        <?php } else { ?>

                            <?= $a['duree_prolongement'] ?>

                        <?php } ?>

                    </td>

                    <td id="date_sent">



                        <?= $a['declaration'] ?>



                    </td>

                    <td id="date_respanse">



                        <?= $a['date_repanse'] ?>



                    </td>

                    <td><?= $a['personnel'] ?></td>





                    <td class="row">

                        <form method="POST">

                            <input type="hidden" name="_method" value="DELETE">

                            <a href="/dossier/delete/<?= $a['num_jugement'] ?>" id="delete"><i

                                    class="fa fa-trash"

                                    aria-hidden="true"

                                    style="color: red;"></i></a>

                        </form>&nbsp;<a href="/dossier/<?= $a['num_jugement'] ?>/edit"><i

                                class="fa fa-pencil-square" aria-hidden="true"></i></a>&nbsp;









                        <form method="POST" action="/imprimer" accept-charset="UTF-8"

                              id="imprimForm">

                            <?=csrf_field()?>

                            <input type="hidden" name="num_jugement" value="<?= $a['num_jugement'] ?>">

                            <input type="hidden" name="num_dossier" value="<?= $a['num_dossier'] ?>">

                            <input type="hidden" name="num_idtribunal" value="<?= $a['tribunals_id_tribunal'] ?>">



                            <span type="submit"  style="width: 0px;height:0px;padding: 0;margin: 0;" id="submit"><i class="fa fa-file-word-o fa" aria-hidden="true" style="color:black;"></i></span>



                        </form>

                    </td>

                </tr>



                <?php



            }



        }

    }

    /**



     * imprimer des ticket

     */

    public function ticket(Request $request){

        $coordonnee=[];

        $id_procureur=[];

        $adresse_av_pr=[];

        $adresse_av_de=[];

        $jugement=Jugement::where('num_jugement',$request->num_jugement)->where('dossiers_num_dossier',$request->num_dossier)->where('tribunals_id_tribunal',$request->num_idtribunal)->first();

        $jugements_autres=Jugements_autres::where('jugements_num_jugement',$request->num_jugement)->where('jugements_dossiers_num_dossier',$request->num_dossier)->where('jugements_tribunals_id_tribunal',$request->num_idtribunal)->get();

        $jugements_procureurs=Jugements_procureurs::where('jugements_num_jugement',$request->num_jugement)->where('jugements_dossiers_num_dossier',$request->num_dossier)->get();

        $jugements_defendeurs=Jugements_defendeurs::where('jugements_num_jugement',$request->num_jugement)->where('jugements_dossiers_num_dossier',$request->num_dossier)->get();


        $nom_avocat_de=[];
        $nom_avocat_pr=[];
        //echo $dateconv['0'];

        $i=0;

        foreach ($jugements_procureurs as $jugements_procureur) {

            $i++;

            $procureur = Procureur::where('id_procureur', $jugements_procureur->procureurs_id_procureur)->first();

            $id_procureur[] = $procureur->id_procureur;

            $coordonnee[$i][]=$procureur->nom_procureur;

            $coordonnee[$i][]=$procureur->adresse_procureur;

        }



        foreach ($jugements_defendeurs as $d=>$jugements_defendeur) {

            $defendeur = Defendeur::where('id_defendeur', $jugements_defendeur->defendeurs_id_defendeur)->first();

            $id_defendeur[] = $defendeur->id_defendeur;

            $i++;

            $coordonnee[$i][]=$defendeur->nom_defendeur;

            $coordonnee[$i][]=$defendeur->adresse_defendeur;

        }



        foreach ($id_procureur as $v) {





            $procureurs_avocats = Procureurs_avocats::where('procureurs_id_procureur', $v)->get();

            foreach ($procureurs_avocats as $procureurs_avocat) {



                $avocat = Avocat::where('id_avocat', $procureurs_avocat->avocats_id_avocat)->first();

//

                $adresse_av_pr[] = $avocat->adresse_avocat;

                $nom_avocat_pr[] = $avocat->nom_avocat;

            }

        }

        $nom_av=array_unique($nom_avocat_pr);

        foreach ($nom_av as $m=>$nameav){

            $i++;

            $coordonnee[$i][]=$nameav;

            $coordonnee[$i][]=$adresse_av_pr[$m];

        }



        foreach ($id_defendeur as $v1){





            $defendeurs_avocats=Defendeurs_avocats::where('defendeurs_id_defendeur',$v1)->get();

            foreach ($defendeurs_avocats as $defendeurs_avocat) {



                $avocat=Avocat::where('id_avocat',$defendeurs_avocat->avocats_id_avocat)->first();



                $nom_avocat_de[]=$avocat->nom_avocat;

                $adresse_av_de[]=$avocat->adresse_avocat;

            }



        }

        $nom_av_de=array_unique($nom_avocat_de);

        foreach ($nom_av_de as $h=>$nameavde){

            $i++;

            $coordonnee[$i][]=$nameavde;

            $coordonnee[$i][]=$adresse_av_de[$h];

        }



        foreach ($jugements_autres as $jugements_autre) {

            $autre = Autre::where('id_autre', $jugements_autre->autres_id_autre)->first();

            $i++;

            $coordonnee[$i][]=$autre->description_autre;

            $coordonnee[$i][]='';

        }













        $phpWord = new \PhpOffice\PhpWord\PhpWord();

//        $phpWord->addParagraphStyle('My Style', array(
//
//                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(6))
//
//        );

        $section = $phpWord->addSection();
        $sectionStyle = $section->getStyle();

// half inch left margin

        $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(15));

        $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(13));

        $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(13));

        $sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(10));

        $phpWord->setDefaultFontName('Arial');

        $fancyTableStyleName = 'Fancy Table';

        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 40, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);

        $fancyTableFirstRowStyle1 = array('bgColor' => 'FFFFFF');

        $fancyTableCellStyle = array('valign' => 'center');



        $tableStyle = array(
            'borderColor' => '006699',
            'borderSize' => 6,
            'cellMargin' => 100,
            'align'=>'center'
        );
        $firstRowStyle = array();
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
        $table = $section->addTable('myTable');
//        dd($coordonnee);
        $p=4;
        $table->addRow(1000);
        for($i=1;$i<=count($coordonnee);$i++) {

            $l1 = $coordonnee[$i][0];
            $l2 = $coordonnee[$i][1];
//            if($i!=count($coordonnee) && isset($coordonnee[$i+2]) && isset($coordonnee[$i+3])){
//                $l3 = $coordonnee[$i + 1][0];
//                $l4 = $coordonnee[$i + 1][1];
//                $l5 = $coordonnee[$i + 2][0];
//                $l6 = $coordonnee[$i + 2][1];
//            }
            if($i == $p){
                $table->addRow(1000);
                $p=$p+3;

            }
            $c1=$table->addCell(4500);
            $c1->addText("$l1 <w:br /> $l2", array('rtl'=>true,'size' => 10, 'name' => 'arial'), array("alignment" => "right"));
//            if($i!=count($coordonnee) && isset($coordonnee[$i+2]) && isset($coordonnee[$i+3])) {
//                $c2 = $table->addCell(4500);
//                $c2->addText("$l3 <w:br /> $l4", array('rtl' => true, 'size' => 10, 'name' => 'arial'), array("alignment" => "right"));
//                $c3 = $table->addCell(4500);
//                $c3->addText("$l5 <w:br /> $l6", array('rtl' => true, 'size' => 10, 'name' => 'arial'), array("alignment" => "right"));
//
//            }

        }

//
        header("Content-Description: File Transfer");

        header('Content-Disposition: attachment; filename=tickets.docx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        header('Content-Transfer-Encoding: binary');

        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

        header('Expires: 0');

        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        $xmlWriter->save('php://output');



    }


    public function sticky(Request $request){

        $coordonnee=[];

        $id_procureur=[];

        $adresse_av_pr=[];

        $adresse_av_de=[];

        $jugement=Jugement::where('num_jugement',$request->num_jugement)->where('dossiers_num_dossier',$request->num_dossier)->where('tribunals_id_tribunal',$request->num_idtribunal)->first();

        $jugements_autres=Jugements_autres::where('jugements_num_jugement',$request->num_jugement)->where('jugements_dossiers_num_dossier',$request->num_dossier)->where('jugements_tribunals_id_tribunal',$request->num_idtribunal)->get();

        $jugements_procureurs=Jugements_procureurs::where('jugements_num_jugement',$request->num_jugement)->where('jugements_dossiers_num_dossier',$request->num_dossier)->get();

        $jugements_defendeurs=Jugements_defendeurs::where('jugements_num_jugement',$request->num_jugement)->where('jugements_dossiers_num_dossier',$request->num_dossier)->get();



        //echo $dateconv['0'];
        $nom_avocat_de=[];
        $i=0;
        $nom_avocat_pr=[];
        foreach ($jugements_procureurs as $jugements_procureur) {

            $i++;

            $procureur = Procureur::where('id_procureur', $jugements_procureur->procureurs_id_procureur)->first();

            $id_procureur[] = $procureur->id_procureur;

            $coordonnee[$i][]=$procureur->nom_procureur;

            $coordonnee[$i][]=$procureur->adresse_procureur;

        }



        foreach ($jugements_defendeurs as $d=>$jugements_defendeur) {

            $defendeur = Defendeur::where('id_defendeur', $jugements_defendeur->defendeurs_id_defendeur)->first();

            $id_defendeur[] = $defendeur->id_defendeur;

            $i++;

            $coordonnee[$i][]=$defendeur->nom_defendeur;

            $coordonnee[$i][]=$defendeur->adresse_defendeur;

        }



        foreach ($id_procureur as $v) {





            $procureurs_avocats = Procureurs_avocats::where('procureurs_id_procureur', $v)->get();

            foreach ($procureurs_avocats as $procureurs_avocat) {



                $avocat = Avocat::where('id_avocat', $procureurs_avocat->avocats_id_avocat)->first();

//

                $adresse_av_pr[] = $avocat->adresse_avocat;

                $nom_avocat_pr[] = $avocat->nom_avocat;

            }

        }

        $nom_av=array_unique($nom_avocat_pr);

        foreach ($nom_av as $m=>$nameav){

            $i++;

            $coordonnee[$i][]=$nameav;

            $coordonnee[$i][]=$adresse_av_pr[$m];

        }



        foreach ($id_defendeur as $v1){





            $defendeurs_avocats=Defendeurs_avocats::where('defendeurs_id_defendeur',$v1)->get();

            foreach ($defendeurs_avocats as $defendeurs_avocat) {



                $avocat=Avocat::where('id_avocat',$defendeurs_avocat->avocats_id_avocat)->first();



                $nom_avocat_de[]=$avocat->nom_avocat;

                $adresse_av_de[]=$avocat->adresse_avocat;

            }



        }

        $nom_av_de=array_unique($nom_avocat_de);

        foreach ($nom_av_de as $h=>$nameavde){

            $i++;

            $coordonnee[$i][]=$nameavde;

            $coordonnee[$i][]=$adresse_av_de[$h];

        }



        foreach ($jugements_autres as $jugements_autre) {

            $autre = Autre::where('id_autre', $jugements_autre->autres_id_autre)->first();

            $i++;

            $coordonnee[$i][]=$autre->description_autre;

            $coordonnee[$i][]='';

        }













        $phpWord = new \PhpOffice\PhpWord\PhpWord();

//        $phpWord->addParagraphStyle('My Style', array(
//
////                'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(6))
//
//        );

        $section = $phpWord->addSection(array('orientation'=>'landscape'));

        $sectionStyle = $section->getStyle();

// half inch left margin

        $sectionStyle->setMarginTop(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(15));

        $sectionStyle->setMarginLeft(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(10));

        $sectionStyle->setMarginRight(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(18));

        $sectionStyle->setMarginBottom(\PhpOffice\PhpWord\Shared\Converter::cmToPixel(10));

//        $phpWord->setDefaultFontName('Arial');

//        $fancyTableStyleName = 'Fancy Table';
//
////        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 40, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
//
//        $fancyTableFirstRowStyle1 = array('bgColor' => 'FFFFFF');
//
//        $fancyTableCellStyle = array('valign' => 'center');

        $tableStyle = array(
            'borderColor' => '006699',
            'borderSize' => 6,
            'cellMargin' => 100
        );
        $firstRowStyle = array();
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
        $table = $section->addTable('myTable');


        $p1=4;
        $table->addRow();
        for($i=1;$i<=count($coordonnee);$i++) {

            $l1 = $coordonnee[$i][0];
            $l2 = $coordonnee[$i][1];
//            if($i!=count($coordonnee)){
//                $l3 = $coordonnee[$i + 1][0];
//                $l4 = $coordonnee[$i + 1][1];
//                $l5 = $coordonnee[$i + 2][0];
//                $l6 = $coordonnee[$i + 2][1];
//            }
//            $table = $section->addTable(array('align'=>'center','borderSize'=>1,'cellMargin'=>10));
            if($i==$p1){
                $table->addRow();
                $p1=$p1+3;
            }
            $c1=$table->addCell(5000);
            $c1->addText("$l1 <w:br /> $l2", array('rtl'=>true,'size' => 10, 'name' => 'arial'), array("alignment" => "right"));
//            if($i!=count($coordonnee)) {
//                $c2 = $table->addCell(5000);
//                $c2->addText("$l3 <w:br /> $l4", array('rtl' => true, 'size' => 10, 'name' => 'arial'), array("alignment" => "right"));
//                $c3 = $table->addCell(5000);
//                $c3->addText("$l5 <w:br /> $l6", array('rtl' => true, 'size' => 10, 'name' => 'arial'), array("alignment" => "right"));
//
//            }

        }





//      ////            $file = 'HelloWorld.'.$key.'.docx';

        header("Content-Description: File Transfer");

        header('Content-Disposition: attachment; filename=tickets.docx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');

        header('Content-Transfer-Encoding: binary');

        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

        header('Expires: 0');

        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        $xmlWriter->save('php://output');

    }

// /************************************        PRINT REPORT         ************************************************ */
  public function report(Request $request)
    {

        $jugement = Jugement::where('num_jugement', $request->num_jugement)->where('dossiers_num_dossier', $request->num_dossier)->first();
        $jugements_autres = Jugements_autres::where('jugements_num_jugement', $request->num_jugement)->where('jugements_dossiers_num_dossier', $request->num_dossier)->get();
        $tribunal_ville = Tribunals_villes::where('jugement_id', $request->num_jugement)->first();
        $tribunal = Tribunal::where('id_tribunal', $tribunal_ville->id_tribunal)->first();
        $ville = Villes::where('id_ville', $tribunal_ville->id_ville)->first();
        $convocation = Convocation::where('jugements_num_jugement', $request->num_jugement)->where('jugements_dossiers_num_dossier', $request->num_dossier)->first();

        $jugements_procureurs = Jugements_procureurs::where('jugements_num_jugement', $request->num_jugement)->where('jugements_dossiers_num_dossier', $request->num_dossier)->get();
        $jugements_defendeurs = Jugements_defendeurs::where('jugements_num_jugement', $request->num_jugement)->where('jugements_dossiers_num_dossier', $request->num_dossier)->get();
        $immobilier2 = Immobilier::where('jugements_num_jugement', $request->num_jugement)->where('jugements_dossiers_num_dossier', $request->num_dossier)->where('adresse_immobilier','LIKE', '%'.$convocation->lieu_convocation.'%')->first();
        $immobilier1 = Immobilier::where('jugements_num_jugement', $request->num_jugement)->where('jugements_dossiers_num_dossier', $request->num_dossier)->get();
        $datec = date('Y/m/d h:i', strtotime($convocation->date_convocation));
        $dateconv = explode(' ', $datec);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
//======================================================== page 0 =======================
        $section0 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'marginTop'=>150,'marginBottom'=>10]);
        $nom_ville='';
        $ville_nom=$ville->nom_ville;
        $tribunal_nom=$tribunal->nom_tribunal;
        $tribunal_nom1=$tribunal->nom_tribunal;

        if($tribunal_nom=='محكمة الاستئناف'){
            $tribunal_nom=explode('محكمة',$tribunal_nom);
        }else if($tribunal_nom=='المحكمة الابتدائية'){
            $tribunal_nom=explode('المحكمة',$tribunal_nom);
        }
        if($ville_nom=='الدار البيضاء'){
            $nom_ville=explode('الدار',$ville_nom);
        }
        $path=rtrim(public_path(),'public').'scripts/uploads/pictures/';
        $textrun = $section0->addTextRun();
        $textrun->addImage($path.'garde.jpeg', array('wrappingStyle' => 'behind','marginTop' => 3, 'marginLeft' => -1, 'align' => 'center', 'positioning'=>'relative','width'=>710.929134,'height'=>1091.149606));
        $section0->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section0->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $table = $section0->addTable(['align'=>'right']);
        $table->addRow();
        $table->addCell('2400',['borderSize'=>20,'bgcolor'=>'#FFD243'])->addText(htmlspecialchars(date('Y/m/d'), ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'arial'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1));
        $table->addCell('1400')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'arial'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1));
        $table->addCell('6250')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'arial'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1));
        $section0->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section0->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 18));;
        $table = $section0->addTable(['align'=>'right']);
        $table->addRow();
        $l=$table->addCell('10400');
        $l->addText(htmlspecialchars('إلى مرفوع قضائية خبرة تقرير', ENT_COMPAT, 'UTF-8'), array('size' => 24, 'bold' => true, 'name' => 'arial'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1.5));
        if($tribunal_nom1=='المحكمة الابتدائية'){
            if ($ville_nom === 'الدار البيضاء') {
                $l->addText(htmlspecialchars($nom_ville[1] . ' بالدار المدنية' . $tribunal_nom[1] . ' المحكمة رئيس السيد', ENT_COMPAT, 'UTF-8'), array('size' => 24, 'bold' => true, 'name' => 'arial'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1));
            } else {
                $l->addText(htmlspecialchars('ب' . $ville_nom . ' المدنية' . $tribunal_nom[1] . ' المحكمة رئيس السيد', ENT_COMPAT, 'UTF-8'), array('size' => 24, 'bold' => true, 'name' => 'arial'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1));

            }
        }
        if($tribunal_nom1=='محكمة الاستئناف'){
            if ($ville_nom === 'الدار البيضاء') {
                $l->addText(htmlspecialchars($nom_ville[1] . ' بالدار المدنية' . $tribunal_nom[1] . ' محكمة رئيس السيد', ENT_COMPAT, 'UTF-8'), array('size' => 24, 'bold' => true, 'name' => 'arial'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1));
            } else {
                $l->addText(htmlspecialchars('ب' . $ville_nom . ' المدنية' . $tribunal_nom[1] . ' محكمة رئيس السيد', ENT_COMPAT, 'UTF-8'), array('size' => 24, 'bold' => true, 'name' => 'arial'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1));

            }
        }
        $table->addCell('400')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'arial'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1));
        $table->addCell('750')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'arial'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1));
        $section0->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' =>1.5));;
        $path2=rtrim(public_path(),'public').'scripts/uploads/satellite/';
        $img_satellite='';
        $img_face_immo='';

        if($convocation->lieu_convocation=='المكتب'){
            $img_satellite=$immobilier1[0]->img_satellite;
            $img_face_immo=$immobilier1[0]->img_immobilier;
        }else{
            foreach ($immobilier1 as $im){
                if($im->num_immobilier==$convocation->lieu_convocation){
                    $img_satellite=$im->img_satellite;
                    $img_face_immo=$im->img_immobilier;
                }

            }
        }
        $table = $section0->addTable(['align'=>'center']);
        $table->addRow();
        $table->addCell()->addImage($path2 . "$img_satellite",[
            'align' => 'center',
            'height' => 245,
            'width' => 155
        ]);
        $table->addCell('100');
        $table->addCell()->addImage($path . "$img_face_immo", [
            'align' => 'centre',
            'height' => 245,
        ]);

        $section0->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 0.1));;
        $date_j = date('Y/m/d h:i', strtotime($jugement->date_jugement));
        $date_j=explode(' ', $date_j);
        $nom_juge=explode(' ',$jugement->nom_juge);

        $table = $section0->addTable(['align'=>'right']);
        $table->addRow();
        $l1=$table->addCell('7000');
        $l1->addText(htmlspecialchars($jugement->dossiers_num_dossier, ENT_COMPAT, 'UTF-8'), array('size' => 13, 'bold' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 2.1));
        $l1->addText(htmlspecialchars($jugement->num_jugement, ENT_COMPAT, 'UTF-8'), array('size' => 13, 'bold' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1.8));
        $l1->addText(htmlspecialchars($date_j[0], ENT_COMPAT, 'UTF-8'), array('size' => 13, 'bold' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1.9));

        $nome_juge='';
        for($i=count($nom_juge)-1;$i>=0;$i--){
            $nome_juge.=' '.$nom_juge[$i];
        }
        $l1->addText(htmlspecialchars($nome_juge." (ة)الأستاذ ", ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1));

        $table->addCell('2950')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'arial'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1));




//        ===========================================page 1==================================================================
        $section = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);

        $section->getStyle()->setPageNumberingStart(1);
        $header = $section->addHeader();
        $table = $header->addTable(['align' => 'right']);
        $table->addRow();

        $path=rtrim(public_path(),'public').'scripts/uploads/pictures/';
        $table->addCell(4500)->addImage($path . '2.png', [
            'width' => 66,
            'align' => 'left',
            'marginTop' => -1,
            'marginLeft' => -1,
            'posHorizontal' => 'right',
        ]);
        $textbox = $table->addCell(8500)->addTextBox(['width' => 453, 'height' => 35, 'stroke' => 0, 'align' => 'center', 'borderSize' => 2, 'borderColor' => '#ffb800']);
        $textbox->addText(" $request->num_dossier : رقم ملف  - قضائية خبرة تقرير  ", ['bold' => true, 'size' => 14, 'name' => 'arial'], ['align' => 'center']);
        $table->addCell(10500)->addImage($path . '1.png', [
            'width' => 66,
            'marginTop' => -1,
            'marginRight' => -1,
            'posHorizontal' => 'right',
            'positioning'=>'absolute',
            'align' => 'right'
        ]);
//        $section->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('size' => 36, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 3));;
//        $section->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('size' => 36, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 3));;

        $section->addText(htmlspecialchars(' سلام تام بوجود مولانا الإمام', ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>700,'after'=>600],'indentation'=>['left'=>540,'right'=>540]));;
        $section->addText(htmlspecialchars('وبعد، سيدي الرئيس،', ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['after'=>250],'indentation'=>['left'=>540,'right'=>540]));;
        $section->addText(htmlspecialchars('يشرفني أن أوافي جانبكم بتقرير الخبرة الذي كلفت بإنجازه في الملف المشار إلى مراجعه ', ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>700],'indentation'=>['left'=>540,'right'=>540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2.15));;
        $date_jugement = date('d-m-Y', strtotime($jugement->date_jugement));
        $text="أعلاه وفق الحكم المؤرخ بتاريخ".' '.$date_jugement.' '."والذي مفاده :";
        $section->addText(htmlspecialchars( $text, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['after'=>280],'indentation'=>['left'=>540,'right'=>540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2.15));;

//        $textrun1 = $section->addTextRun(array('marginRight' => 200, 'marginLeft' => 3500, 'align' => 'right'));
//        $styleFont = array('rtl' => true, 'size' => 16, 'name' => 'arial');
//        $textrun1->addText("أعلاه وفق الحكم المؤرخ بتاريخ", $styleFont,['space'=>['after'=>250],'indentation'=>['left'=>540,'right'=>540]]);
//        $textrun1->addText("$date_jugement" . ' ', $styleFont);
//        $textrun1->addText("والذي مفاده :" . ' ', $styleFont);
        $section->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('size' => 36, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 3));;
        $section->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('size' => 36, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 4));;
        $tableStyle = array(
            'borderSize' => 19,
            'align' => 'center'
        );
        $firstRowStyle = array('bgColor' => 'ffC000', 'borderSize' => 19);
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
        $table = $section->addTable('myTable');
        $table->addRow();
        $table->addCell('6240')->addText(htmlspecialchars('الحكم ماهية -1', ENT_COMPAT, 'UTF-8'), array('size' => 48, 'bold' => true, 'name' => 'arial'), array("align" => "center",'space'=>['before'=>100,'after'=>0]));
        $footer = $section->addFooter();
        $footer->addPreserveText('{PAGE}', null, array('align' => 'center'));
        //==================================================== page 2 ==================================================================
        $decision=Dossier::where('num_dossier',$jugement->dossiers_num_dossier)->first();

        $section1 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);

//        $section1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 3));;
//        $section1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 3));;
//        $section1->addText(htmlspecialchars("إجراء خبرة عقارية وذلك باستدعاء أطراف الدعوى ووكلائهم طبقا لمقتضيات الفصل 63 من ق م م والانتقال إلى عين العقار المدعى فيه موضوع الرسم العقاري عدد 19054/64 الموصوف بصلب المقال قصد معاينته ووصفه وصفا دقيقا مع تحديد ماهيته المادية والقانونية والقول ما اذا كان هذا العقار قابلا للقسمة ام لا ؟ وفي حالة الإيجاب إعداد مشروعين او اكثر لقسمته قسمة عينية وفرز نصيب الطرف المدعي على ضوء الحصة (النسبة) التي يملكها في العقار المذكور مع مراعاة مقتضيات الظهير الشريف رقم 1.92.7 المؤرخ في 17 يونيو 1992 بتنفيذ القانون رقم 90-25 المتعلق التجزئات العقارية والمجموعات السكنية وتقسيم العقارات والظهير الشريف رقم 1.02.298 المؤرخ في 03/10/2002 بتنفيذ القانون رقم 18.00 المتعلق بنظام الملكية المشتركة للعقارات المبنية،وفي حالة السلب تحديد الثمن الافتتاحي لبيعه بالمزاد العلني . ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "distribute", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section1->addText(htmlspecialchars($decision->decision_jugement, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "distribute",'space'=>['before'=>700,'after'=>280],'indentation'=>['left'=>540,'right'=>540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
//        $section1->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;

//  ================================================================= page 3 ===============================================================================

        $section2 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);


        $section2->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section2->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section2->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section2->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section2->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section2->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section2->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section2->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section2->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section2->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 3));;

        $firstRowStyle = array('bgColor' => 'ffad00', 'borderSize' => 19);
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
        $table = $section2->addTable('myTable');
        $table->addRow();
        $table->addCell('7400')->addText(htmlspecialchars('الإنجاز -2', ENT_COMPAT, 'UTF-8'), array('size' => 48, 'bold' => true, 'name' => 'arial'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1));


//        ================================================================= page 4================================================
        $section3 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);


        $section3->addText(htmlspecialchars("عند توصلي بالمأمورية المسندة إلي من طرف المحكمة الموقرة ، قمت بالاجراءات ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 17, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>700],'indentation'=>['left'=>540,'right'=>540]));;
        $section3->addText(htmlspecialchars("التالية :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['after'=>280],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;

        $styleCell = array('borderSize' => 20,'bgcolor'=>'#c00000');

        $tableStyle4 = array(
            'align' => 'right',
            'cellMargin'=>(0|130|0|0)

        );
        $firstRowStyle4 = array();
        $phpWord->addTableStyle('myTable4', $tableStyle4, $firstRowStyle4);

        $table3 = $section3->addTable('myTable4');

        $table3->addRow();

        $table3->addCell('8010')->addText(htmlspecialchars('   : ق م م من 63 للفصل طبقا ونوابهم الأطراف إستدعاء -  ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));

        $table3->addCell('750', $styleCell)->addText(htmlspecialchars('2-1', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
        $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation'=>['left'=>20,'right'=>20]));
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 30, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("عملا بالمقتضيات القانونية ، وجهت رسائل الاستدعاء إلى كل من :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>280],'indentation'=>['left'=>540,'right'=>540]));;


        $section3->addText(htmlspecialchars(" : المدعي الطرف  •", ENT_COMPAT, 'UTF-8'), array( 'size' => 16, 'bold' => true, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>280],'indentation'=>['left'=>540,'right'=>1500]));;
        $id_procureur = [];
        $nom_pro = [];
        $nom_avocat_pr = [];

        $nom_pro=[];
        foreach ($jugements_procureurs->all() as $i => $jugements_procureur) {
            $procureur = Procureur::where('id_procureur', $jugements_procureur->procureurs_id_procureur)->first();
            $procureurs_avocats = Procureurs_avocats::where('procureurs_id_procureur', $procureur->id_procureur)->get();
            if(!empty($procureurs_avocats->all())) {
                foreach ($procureurs_avocats as $pa) {
                    $nom_pro[$pa->avocats_id_avocat][] = $procureur->id_procureur;
                }
            }else{
                $nom_pro[$i.'p'][] = $procureur->id_procureur;
            }

        }

        $vr='';
        $vr1=[];
        $table3 = $section3->addTable(['align' => 'right']);


        $nom_avocat_pr1=[];
        $key1='';

        foreach ($nom_pro as $p) {
            if ($key1 != $p[0]) {
                $key1=$p[0];
                foreach ($p as $v) {

                    $pr = Procureur::where('id_procureur', $v)->first();
                    $pr_avocats = Procureurs_avocats::where('procureurs_id_procureur', $v)->get();
                    foreach ($pr_avocats as $v) {
                        $avocat = Avocat::where('id_avocat', $v->avocats_id_avocat)->first();

                        $nom_avocat_pr1[] = $avocat;
                    }
                    $vr = $pr;

                    $table3->addRow();
                    if ($vr->genre == 'M') {
                        $table3->addCell('7000', ['cellMargin' => 0])->addText(htmlspecialchars('السيد ' . "$pr->nom_procureur", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                    } else if ($vr->genre == 'F') {
                        $table3->addCell('7000', ['cellMargin' => 0])->addText(htmlspecialchars('السيدة ' . "$pr->nom_procureur", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                    }
                    $table3->addCell('300')->addText(htmlspecialchars(" – ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                    $table3->addCell('2200', ['cellMargin' => 0])->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                    $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 30, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 0.5));;

                }
                if (count($p) == 1) {
                    if (count($nom_avocat_pr1) > 1) {

                        $return1 = $nom_avocat_pr1[0];
                        $return2 = $nom_avocat_pr1[1];
//

                        $table3->addRow();
                        if($vr->genre=='M') {
                            if ($return1->genre == 'M' && $return2->genre == 'M') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنه الأستاذ " . ' ' . "$return1->nom_avocat" . ' محامي بهيئة ' . $return1->ville . ' و الأستاذ ' . "$return2->nom_avocat" . ' محامي بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                            } else if ($return1->genre == 'M' && $return2->genre == 'F') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنه الأستاذ " . ' ' . "$return1->nom_avocat" . ' محامي بهيئة ' . $return1->ville . ' و الأستاذة ' . "$return2->nom_avocat" . ' محامية بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                            } else if ($return1->genre == 'F' && $return2->genre == 'F') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنه الأستاذة " . ' ' . "$return1->nom_avocat" . ' محامية بهيئة ' . $return1->ville . ' و الأستاذة ' . "$return2->nom_avocat" . ' محامية بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                            } else if ($return1->genre == 'F' && $return2->genre == 'M') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنه الأستاذة " . ' ' . "$return1->nom_avocat" . ' محامية بهيئة ' . $return1->ville . ' و الأستاذ ' . "$return2->nom_avocat" . ' محامي بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                            }
                        }else if($vr->genre=='F'){
                            if ($return1->genre == 'M' && $return2->genre == 'M') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنها الأستاذ " . ' ' . "$return1->nom_avocat" . ' محامي بهيئة ' . $return1->ville . ' و الأستاذ ' . "$return2->nom_avocat" . ' محامي بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                            } else if ($return1->genre == 'M' && $return2->genre == 'F') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنها الأستاذ " . ' ' . "$return1->nom_avocat" . ' محامي بهيئة ' . $return1->ville . ' و الأستاذة ' . "$return2->nom_avocat" . ' محامية بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                            } else if ($return1->genre == 'F' && $return2->genre == 'F') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنها الأستاذة " . ' ' . "$return1->nom_avocat" . ' محامية بهيئة ' . $return1->ville . ' و الأستاذة ' . "$return2->nom_avocat" . ' محامية بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                            } else if ($return1->genre == 'F' && $return2->genre == 'M') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنها الأستاذة " . ' ' . "$return1->nom_avocat" . ' محامية بهيئة ' . $return1->ville . ' و الأستاذ ' . "$return2->nom_avocat" . ' محامي بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                            }

                        }
                        $table3->addCell('300')->addText(htmlspecialchars("  ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                        $table3->addCell('1000', ['cellMargin' => 0])->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));

////
                    } else if (count($nom_avocat_pr1) == 1) {

                        $return = $nom_avocat_pr1[0];
                        $table3->addRow();
                        if ($vr->genre == 'M') {
                            if ($return->genre == 'M') {
                                $table3->addCell('7500')->addText(htmlspecialchars("والنائب عنه الأستاذ" . ' ' . "$return->nom_avocat" . ' محامي بهيئة' . ' ' . $return->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            } else if ($return->genre == 'F') {
                                $table3->addCell('7500')->addText(htmlspecialchars("والنائبة عنه الأستاذة" . ' ' . "$return->nom_avocat" . ' محامية بهيئة' . ' ' . $return->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            }

                        }
                        if ($vr->genre == 'F') {
                            if ($return->genre == 'M') {
                                $table3->addCell('7500')->addText(htmlspecialchars("والنائب عنها الأستاذ" . ' ' . "$return->nom_avocat" . ' محامي بهيئة' . ' ' . $return->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            } else if ($return->genre == 'F') {
                                $table3->addCell('7500')->addText(htmlspecialchars("والنائبة عنها الأستاذة" . ' ' . "$return->nom_avocat" . ' محامية بهيئة' . ' ' . $return->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                            }
                        }
                        $table3->addCell('300')->addText(htmlspecialchars("  ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                        $table3->addCell('1000', ['cellMargin' => 0])->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
//

                    }

                } else if (count($p) > 1) {
                    $return = $nom_avocat_pr1[0];

                    $table3->addRow();
                    if ($return->genre == 'M') {
                        $table3->addCell('7500')->addText(htmlspecialchars(" والنائب عنهم الأستاذ" . ' ' . $return->nom_avocat . ' محامي بهيئة ' . $return->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                    } else if ($return->genre == 'F') {
                        $table3->addCell('7500')->addText(htmlspecialchars(" والنائبة عنهم الأستاذة" . ' ' . $return->nom_avocat . ' محامية بهيئة ' . $return->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                    }
                    $table3->addCell('300')->addText(htmlspecialchars("  ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                    $table3->addCell('1000', ['cellMargin' => 0])->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));

                }

                $nom_avocat_pr1 = [];
            }
        }


        $section3->addText(htmlspecialchars(": عليه المدعى الطرف  •", ENT_COMPAT, 'UTF-8'), array( 'size' => 16, 'bold' => true, 'name' => 'arial'), array("align" => "right",'space'=>['after'=>280],'indentation'=>['left'=>540,'right'=>1500]));;
        $adresse_av_de = [];

//8888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888
        $nom_def=[];
        foreach ($jugements_defendeurs->all() as $i => $jugements_defendeur) {
            $defendeur = Defendeur::where('id_defendeur', $jugements_defendeur->defendeurs_id_defendeur)->first();
//
            $defendeurs_avocats = Defendeurs_avocats::where('defendeurs_id_defendeur', $defendeur->id_defendeur)->get();
            if(!empty($defendeurs_avocats->all())) {
                foreach ($defendeurs_avocats as $da) {
                    $nom_def[$da->avocats_id_avocat][] = $defendeur->id_defendeur;
                }
            }else{
                $nom_def[$i.'d'][] = $defendeur->id_defendeur;

            }
        }
        $vd='';
        $vd1=[];

        $table3 = $section3->addTable(['align' => 'right']);


        $nom_avocat_def1=[];
        $key2='';
        foreach ($nom_def as $p) {
            if ($key2 != $p[0]) {
                $key2 = $p[0];
                foreach ($p as $v) {
                    $de = Defendeur::where('id_defendeur', $v)->first();
                    $de_avocats = Defendeurs_avocats::where('defendeurs_id_defendeur', $v)->get();

                    foreach ($de_avocats as $v) {
                        $avocat = Avocat::where('id_avocat', $v->avocats_id_avocat)->first();

                        $nom_avocat_def1[] = $avocat;
                    }
                    $vd = $de;

                    $table3->addRow();
                    if ($vd->genre == 'M') {
                        $table3->addCell('7000', ['cellMargin' => 0])->addText(htmlspecialchars('السيد ' . "$de->nom_defendeur", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                    } else if ($vd->genre == 'F') {
                        $table3->addCell('7000', ['cellMargin' => 0])->addText(htmlspecialchars('السيدة ' . "$de->nom_defendeur", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                    }
                    $table3->addCell('300')->addText(htmlspecialchars(" – ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                    $table3->addCell('2200', ['cellMargin' => 0])->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));

                }

                if (count($p) == 1) {
                    if (count($nom_avocat_def1) > 1) {

                        $return1 = $nom_avocat_def1[0];
                        $return2 = $nom_avocat_def1[1];


                        $table3->addRow();
                        if($vd->genre=='M') {
                            if ($return1->genre == 'M' && $return2->genre == 'M') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنه الأستاذ" . ' ' . "$return1->nom_avocat" . ' محامي بهيئة ' . $return1->ville . ' و الأستاذ ' . "$return2->nom_avocat" . ' محامي بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            } else if ($return1->genre == 'M' && $return2->genre == 'F') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنه الأستاذ" . ' ' . "$return1->nom_avocat" . ' محامي بهيئة ' . $return1->ville . ' و الأستاذة ' . "$return2->nom_avocat" . ' محامية بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            } else if ($return1->genre == 'F' && $return2->genre == 'F') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنه الأستاذة" . ' ' . "$return1->nom_avocat" . ' محامية بهيئة ' . $return1->ville . ' و الأستاذة ' . "$return2->nom_avocat" . ' محامية بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            } else if ($return1->genre == 'F' && $return2->genre == 'M') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنه الأستاذة" . ' ' . "$return1->nom_avocat" . ' محامية بهيئة ' . $return1->ville . ' و الأستاذ ' . "$return2->nom_avocat" . ' محامي بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            }
                        }else if($vd->genre=='F'){
                            if ($return1->genre == 'M' && $return2->genre == 'M') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنها الأستاذ" . ' ' . "$return1->nom_avocat" . ' محامي بهيئة ' . $return1->ville . ' و الأستاذ ' . "$return2->nom_avocat" . ' محامي بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            } else if ($return1->genre == 'M' && $return2->genre == 'F') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنها الأستاذ" . ' ' . "$return1->nom_avocat" . ' محامي بهيئة ' . $return1->ville . ' و الأستاذة ' . "$return2->nom_avocat" . ' محامية بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            } else if ($return1->genre == 'F' && $return2->genre == 'F') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنها الأستاذة" . ' ' . "$return1->nom_avocat" . ' محامية بهيئة ' . $return1->ville . ' و الأستاذة ' . "$return2->nom_avocat" . ' محامية بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            } else if ($return1->genre == 'F' && $return2->genre == 'M') {
                                $table3->addCell('8000')->addText(htmlspecialchars("والنائبون عنها الأستاذة" . ' ' . "$return1->nom_avocat" . ' محامية بهيئة ' . $return1->ville . ' و الأستاذ ' . "$return2->nom_avocat" . ' محامي بهيئة ' . $return2->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            }
                        }
                        $table3->addCell('300')->addText(htmlspecialchars("  ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                        $table3->addCell('1000', ['cellMargin' => 0])->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));

                    } else if (count($nom_avocat_def1) == 1) {

                        $return = $nom_avocat_def1[0];
                        $table3->addRow();
                        if ($vd->genre == 'M') {
                            if ($return->genre == 'M') {
                                $table3->addCell('7500')->addText(htmlspecialchars("والنائب عنه الأستاذ" . ' ' . "$return->nom_avocat" . ' محامي بهيئة' . ' ' . $return->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            } else if ($return->genre == 'F') {
                                $table3->addCell('7500')->addText(htmlspecialchars("والنائبة عنه الأستاذة" . ' ' . "$return->nom_avocat" . ' محامية بهيئة' . ' ' . $return->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            }
                        }
                        if ($vd->genre == 'F') {
                            if ($return->genre == 'M') {
                                $table3->addCell('7500')->addText(htmlspecialchars("والنائب عنها الأستاذ" . ' ' . "$return->nom_avocat" . ' محامي بهيئة' . ' ' . $return->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            } else if ($return->genre == 'F') {
                                $table3->addCell('7500')->addText(htmlspecialchars("والنائبة عنها الأستاذة" . ' ' . "$return->nom_avocat" . ' محامية بهيئة' . ' ' . $return->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                            }
                        }
                        $table3->addCell('300')->addText(htmlspecialchars("  ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                        $table3->addCell('1000', ['cellMargin' => 0])->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
//

                    }

                } else if (count($p) > 1) {
                    $return = $nom_avocat_def1[0];

                    $table3->addRow();
                    if ($return->genre == 'M') {
                        $table3->addCell('7500')->addText(htmlspecialchars(" والنائب عنهم الأستاذ" . ' ' . $return->nom_avocat . ' محامي بهيئة ' . $return->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                    } else if ($return->genre == 'F') {
                        $table3->addCell('7500')->addText(htmlspecialchars(" والنائبة عنهم الأستاذة" . ' ' . $return->nom_avocat . ' محامية بهيئة ' . $return->ville, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                    }
                    $table3->addCell('300')->addText(htmlspecialchars("  ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                    $table3->addCell('1000', ['cellMargin' => 0])->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));

                }
                $nom_avocat_def1 = [];
            }
        }


        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 30, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 0.5));;

        if(!empty($jugements_autres->all())) {
            $section3->addText(htmlspecialchars(" : بحضور •", ENT_COMPAT, 'UTF-8'), array( 'size' => 16, 'bold' => true, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>280],'indentation'=>['left'=>540,'right'=>1500]));;
            foreach ($jugements_autres as $key => $jugements_autre) {
                $autre = Autre::where('id_autre', $jugements_autre->autres_id_autre)->first();
                $section3->addText(htmlspecialchars($autre->description_autre, ENT_COMPAT, 'UTF-8'), array( 'size' => 16, 'rtl' => true, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>280],'indentation'=>['left'=>540,'right'=>1500]));;

            }
        }

        $sectiontxt = " لقد تم إرسال رسائل الإستدعاء إلى جميع الأطراف محددا لهم يوم".' '.$dateconv[0].' '."على الساعة".' '.$dateconv[1].' '.$convocation->heure_convocation.' '."كموعد للقيام بالمهمة المنصوص عليها أعلاه .".' '."(أنظر المرفقة  رقم 1) .";
        $section3->addText(htmlspecialchars($sectiontxt, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' =>1.5));

        //===================================================================== page 5 ====================================================
        $num_list = count($immobilier1);
        $atraf = [];
        $a_proc = [];
        $atraf2=[];
        $section3 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);


        $tableStyle5 = array(
            'align' => 'right',
            'cellMargin'=>(0|130|0|0)

        );
        $firstRowStyle5 = array();
        $phpWord->addTableStyle('myTable5', $tableStyle5, $firstRowStyle5);

//        $phpWord->addTableStyle('myTable', $tableStyle3, $firstRowStyle3);
        $table3 = $section3->addTable('myTable5');
        $table3->addRow();
        $table3->addCell('8010')->addText(htmlspecialchars('   :الخبرة موضوع العقار إلى الإنتقال - ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
        $table3->addCell('750',$styleCell)->addText(htmlspecialchars('2-2', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
        $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation'=>['left'=>20,'right'=>20]));

        //b1


        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;

        $styleFont1 = array('rtl' => true, 'size' => 16, 'name' => 'arial');
        if ($convocation->lieu_convocation === "المكتب") {
            $textp5 = "في يوم" . ' ' . $dateconv[0] . " على الساعة " . $dateconv[1] . ' ' . $convocation->heure_convocation . "،تم حضور الأطراف  إلى  " . $convocation->lieu_convocation."، قصد معاينته." ;
        }else{
            $textp5="في يوم".' '.$dateconv[0]." على الساعة ".$dateconv[1].' '.$convocation->heure_convocation."،تم الإنتقال إلى العقار موضوع الخبرة ذي الرسم العقاري عدد  ".$convocation->lieu_convocation."، قصد معاينته.";
        }
        $section3->addText(htmlspecialchars($textp5, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' =>1.5));


        $presence = true;
//        foreach ($jugements_procureurs as $u => $jugements_procureur) {
//            $procureur = Procureur::where('id_procureur', $jugements_procureur->procureurs_id_procureur)->where('present', '1')->first();
//
//
//
//            if (empty($procureur)) {
//                $presence = false;
//            }else{
//                $atraf[] = $procureur->nom_procureur;
//                $a_proc[] = $procureur->nom_procureur;
//
//            }
//
//
//
//
//
//        }

//            $a_def = [];
//        foreach ($jugements_defendeurs as $p => $jugements_defendeur) {
//            $defendeur = Defendeur::where('id_defendeur', $jugements_defendeur->defendeurs_id_defendeur)->where('present', '1')->first();
//
//            if (empty($defendeur)) {
//                $presence = false;
//            } else {
//                $atraf[] = $defendeur->nom_defendeur;
//                $a_def[] = $defendeur->nom_defendeur;
//
//
//            }
//
////
//        }

        $tableStyle3 = array(
            'borderSize' => 19,
            'align' => 'right'
        );
        $firstRowStyle3 = array('bgColor' => 'ffad00', 'borderSize' => 19);
//        $phpWord->addTableStyle('myTable', $tableStyle3, $firstRowStyle3);
//        foreach ($atraf as $p => $value) {
////
//            $section3->addText(htmlspecialchars(" - "."$value", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' =>1.5));
//        }
//        if ($presence == false) {
//            $section3->addText(htmlspecialchars(" وتخلف باقي الأطراف عن الحضور.", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
//
//        }
        $tableStyle6 = array(
            'align' => 'right',
            'cellMargin'=>(0|130|0|0)

        );
        $firstRowStyle6 = array();
        $phpWord->addTableStyle('myTable6', $tableStyle6, $firstRowStyle6);
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $table3 = $section3->addTable('myTable6');
        $table3->addRow();
        $table3->addCell('8010')->addText(htmlspecialchars('   :الأطراف تصريحات و الحضور   - ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
        $table3->addCell('750',$styleCell)->addText(htmlspecialchars('2-3', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
        $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation'=>['left'=>20,'right'=>20]));
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;



//        ========================================================= page 6 =============================================================================================


        $section3->addText(htmlspecialchars("  حضور وتصريحات الأطراف الحاضرة موضح في المرفقة رقم 2.", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
        $tableStyle7 = array(
            'align' => 'right',
            'cellMargin'=>(0|130|0|0)

        );
        $firstRowStyle7 = array();
        $phpWord->addTableStyle('myTable7', $tableStyle6, $firstRowStyle6);
//        $table3 = $section3->addTable('myTable7');
//
//        $table3->addRow();
//        $table3->addCell('8010')->addText(htmlspecialchars('   :الخبرة موضوع العقار موقع وصف  - ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
//        $table3->addCell('750', $styleCell)->addText(htmlspecialchars('2-4', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
//        $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation'=>['left'=>20,'right'=>20]));

        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
        // =========================================================  ============================

        $section3 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);


        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 3));;

        $firstRowStyle = array('bgColor' => 'ffad00', 'borderSize' => 19);
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
        $table = $section3->addTable('myTable');
        $table->addRow();
        $table->addCell('9400')->addText(htmlspecialchars('العقار محيط و موقع -3 ', ENT_COMPAT, 'UTF-8'), array('size' => 48, 'bold' => true, 'name' => 'arial'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 0, 'lineHeight' => 1.2));
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
        $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;

        // =========================================================  ============================
        $var=1;
        foreach ($immobilier1 as $k=>$item) {
            $ni=$item->num_immobilier;
            $city=$item->ville;
            $styleCell = array('borderSize' => 20,'bgcolor'=>'#c00000');

            $tableStyle4 = array(
                'align' => 'right',
                'cellMargin'=>(0|130|0|0)

            );
            $firstRowStyle4 = array();
            $phpWord->addTableStyle('myTable00', $tableStyle4, $firstRowStyle4);

            $table3 = $section3->addTable('myTable00');

            $table3->addRow();
            if($num_list>1){
                $table3->addCell('10010')->addText(htmlspecialchars(':'.$item->num_immobilier.' عدد العقاري الرسم ذي الخبرة موضوع للعقار بالنسبة- ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
            }else{
                $table3->addCell('8010')->addText(htmlspecialchars('   :الخبرة موضوع العقار موقع -  ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
            }
            $table3->addCell('750', $styleCell)->addText(htmlspecialchars('3-'.$var, ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
            $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation'=>['left'=>20,'right'=>20]));
            $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;

            $section3->addText(htmlspecialchars(" يوجد العقار $ni موضوع الخبرة ب$item->adresse_immobilier الذي يعتبر من بين أهم الأحياء بمدينة $city وذلك بحكم كثافته السكانية المهمة و موقعه المميز الذي يوجد على مقربة من جميع المرافق الأساسية والضرورية .", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
            $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 0.7));;
            $var++;

            //      ========================================================= page 7 ========================================================================================
//                $section4 = $phpWord->addSection(['headerHeight' => 300]);
//            $section3 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);
            $section3->addText(htmlspecialchars("موقع العقار موضــوع الخبرة موضــح في الصور التالية :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>1000]));;
            $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 0.5));;
            $path1=rtrim(public_path(),'public').'scripts/uploads/maps/';
            $section3->addImage($path1 . "$item->img_map", ['align' => 'center',
                'height'=>631.937008,
                'width'=>458.07874
            ]);

//        ============================================================== page 8 ========================================
            $section3 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);

            $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
            $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
            $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
            $path2=rtrim(public_path(),'public').'scripts/uploads/satellite/';
            $section3->addImage($path2 . "$item->img_satellite", ['align' => 'center',
                'height'=>796,
                'width'=>575
            ]);
//            $styleCell = array('borderSize' => 20,'bgcolor'=>'#c00000');
//
//            $tableStyle4 = array(
//                'align' => 'right',
//                'cellMargin'=>(0|130|0|0)
//
//            );
//            $firstRowStyle4 = array();
//            $phpWord->addTableStyle('myTable00', $tableStyle4, $firstRowStyle4);
//
//            $table3 = $section3->addTable('myTable00');
//
//            $table3->addRow();
//
//            $table3->addCell('8010')->addText(htmlspecialchars('   :الخبرة موضوع العقار محيط -  ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
//
//            $table3->addCell('750', $styleCell)->addText(htmlspecialchars('3-2', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
//            $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation'=>['left'=>20,'right'=>20]));
//            $section3->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
//            $section3->addText(htmlspecialchars("محيط العقار موضوع الخبرة موضح في الصور المرقمة : 1- 2- 3", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
//            if(!empty($item->img_immo)) {
//                $section3->addImage($path . "$item->img_immo", ['align' => 'center',
//                    'height' => 569.19685,
//                    'width' => 695.433071
//                ]);
//            }
        }

//============================================================== page 9 ===========================================================================
        $section5 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);

        $section5->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $section5->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $section5->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section5->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section5->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section5->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section5->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section5->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section5->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;

        $firstRowStyle = array('bgColor' => 'ffad00','borderSize' => 19);
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
        $table = $section5->addTable('myTable');
        $table->addRow();
        $table->addCell('9600')->addText(htmlspecialchars('للعقار القانونية المعطيات-4', ENT_COMPAT, 'UTF-8'), array('size' => 48, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1));
//     ============================================================= page 10 ========================================
        foreach($immobilier1 as $v=>$immobilier) {
            $immobilier_nature=Immobiliers_natures::where('immobiliers_num_immobilier',$immobilier->num_immobilier)->first();
            $nature=Nature::where('id_nature',$immobilier_nature->natures_id_nature)->first();
            $batiments=Batiment::where('immobiliers_num_immobilier',$immobilier->num_immobilier)->get();
            //si


            $v++;
            $somme_etage2=0;
            $somme_sous_batiment2=0;
            foreach ($batiments as $batiment) {
                $etages_bt1[] = $batiment->designation_etage;
            }
            // affichage des etage qui constitue l'immeuble
            $etages_bt1 = array_unique($etages_bt1);

            $arr_batiment3 = [];

            foreach ($etages_bt1 as $z => $etage) {
                $batiment1 = Batiment::where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('designation_etage', $etage)->get();
                $arr_batiment3[$etage] = $batiment1->all();
            }
            foreach ($arr_batiment3 as $z => $bats){
                if(count($bats) == 1){
                    if ($bats[0]->louer == 0 || $bats[0]->louer == null) {
                        if ($bats[0]->fermer == 0 || $bats[0]->fermer == null) {
                            $somme_sous_batiment2=0;
                            if ($bats[0]->designation_batiment == 'شـقة') {
                                $bt = Batiment::where('designation_batiment', $bats[0]->designation_batiment)->where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('ref_batiment', $bats[0]->ref_batiment)->first();
                                $sous_batiment = Sous_batiment::where('ref_batiment', 'LIKE', $bt->ref_batiment)->get();
                                foreach ($sous_batiment as $u){
                                    $somme_sous_batiment2 = $somme_sous_batiment2 + $u->surface;
                                }
                                $somme_etage2= $somme_etage2+$somme_sous_batiment2;

                            }else{
                                $somme_etage2 = $somme_etage2 + $bats[0]->surface;

                            }
                        }else{
                            if($bats[0]->designation_batiment=='شـقة') {
                                $somme_etage2=$somme_etage2+$bats[0]->surface;
                            }else{
                                $somme_etage2=$somme_etage2+$bats[0]->surface;

                            }
                        }
                    }
                    //affichage des batiment qui se trouve dans les etages

                }else {
//                    $somme_batiment1=0;
                    foreach ($bats as $b) {
                        if ($b->louer == 0 || $b->louer == null) {
                            if ($b->fermer == 0 || $b->fermer == null) {
                                $somme_sous_batiment2=0;
                                if($b->designation_batiment=='شـقة') {
                                    $sous_batiment = Sous_batiment::where('ref_batiment', 'LIKE', $b->ref_batiment)->get();
                                    foreach ($sous_batiment as $sb) {
                                        $somme_sous_batiment2 = $somme_sous_batiment2 + $sb->surface;

                                    }
                                    $somme_etage2= $somme_etage2+$somme_sous_batiment2;
                                }else{
                                    $somme_etage2 = $somme_etage2 + $b->surface;

                                }
                            } else {
                                if($b->designation_batiment=='شـقة') {
                                    $somme_etage2=$somme_etage2+$b->surface;
                                }else{
                                    $somme_etage2=$somme_etage2+$b->surface;

                                }
//                                $somme_batiment1 = $somme_batiment1 + $b->surface;
//                                $somme_etage1 = $somme_etage1 + $b->surface;

                            }
                        }
                    }
                }
            }
            if($nature->designation_nature=='عمارة' || $nature->designation_nature=='فيلا') {
                $surface1=$somme_etage2;
            }else{
                $surface1=$immobilier->surface;

            }
            $etage1=$immobilier->designation_etage;
            $section6 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);
            $tableStyle8 = array(
                'align' => 'right',
                'cellMargin'=>(0|130|0|0)

            );
            $firstRowStyle8 = array();
            $phpWord->addTableStyle('myTable8', $tableStyle8, $firstRowStyle8);
            if($num_list>1) {
                $table3 = $section6->addTable('myTable8');
                $table3->addRow();
                $table3->addCell('10010')->addText(htmlspecialchars(':'.$immobilier->num_immobilier.' عدد العقاري الرسم ذي الخبرة موضوع للعقار بالنسبة- ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                $table3->addCell('750', ['bgColor' => '#c00000', 'borderSize' => 21])->addText(htmlspecialchars('4-' . $v, ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation' => ['left' => 20, 'right' => 20]));
            }
            $section6->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 2));;
            $textrun6 = $section6->addTextRun(array('marginRight' => 70, 'marginLeft' => 2500, 'align' => 'right','space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
            $styleFont1 = array('rtl' => true, 'size' => 16, 'name' => 'arial');
            $textrun6->addText("حسب شهادة الملكية (أنظر المرفقة رقم 3)، فإن العقار موضوع الخبرة يحمل الاسم", $styleFont1);
            $textrun6->addText(' '.'"' . $immobilier->designation_immobilier . '"' . ' ',$styleFont1);
            $textrun6->addText("والرسم العقاري عدد" . ' ', $styleFont1);
            $textrun6->addText("$immobilier->num_immobilier" . ' ',$styleFont1);
            $textrun6->addText("، مساحته" . ' ', $styleFont1);
            $textrun6->addText(" $surface1 سنتيار ", $styleFont1);
            $textrun6->addText(" وهو عبارة عن ", $styleFont1);
            $immobilier_nature = Immobiliers_natures::where('immobiliers_num_immobilier', $immobilier->num_immobilier)->first();
            $nature = Nature::where('id_nature', $immobilier_nature->natures_id_nature)->first();
            $textrun6->addText(" $nature->designation_nature ", $styleFont1);
            if(preg_match("#عمارة#",$nature->designation_nature)==1 || preg_match("#فيلا#",$nature->designation_nature)==1 ){
                $textrun6->addText(" (أنظر شهادة الملكية). "."", $styleFont1);

            }else{
                $textrun6->addText(" بالطابق $etage1 (أنظر شهادة الملكية). "."", $styleFont1);

            }
            $section6->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
            $section6->addText(htmlspecialchars("وحسب شهادة الملكية للعقار موضوع الخبرة (أنظر المرفقة رقم 3)، فإن الأطراف المالكة لهذا العقار ونسب تملكهم موضحة في الجدول التالي :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
            $section6->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 3));;

            $fancyTableStyleName = 'Fancy Table';
            $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
            $fancyTableFirstRowStyle1 = array('bgColor' => 'FFFFFF');
            $fancyTableCellStyle = array('valign' => 'center');

            $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle1);
            $table = $section6->addTable($fancyTableStyleName);
            $table->addRow();
            $col3 = $table->addCell(3900, $fancyTableCellStyle);
            $col3->addText(htmlspecialchars('نسبة التملك في الملك المسمى', ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
            $col3->addText(htmlspecialchars('ذي الرسم"' . $immobilier->designation_immobilier . '"', ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
            $col3->addText(htmlspecialchars(' موضوع ' . "$immobilier->num_immobilier" . 'العقاري عدد، ', ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
            $col3->addText(htmlspecialchars('الخبرة ', ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
            $table->addCell(3400, $fancyTableCellStyle)->addText(htmlspecialchars('الإسم الكامل', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center"));
            $table->addCell(100, $fancyTableCellStyle)->addText(htmlspecialchars('العدد  ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center"));
            $atraf3=[];
            $procureur_immobilier='';

            foreach ($jugements_procureurs->all() as $u => $jugements_procureur) {
                $procureur_immobilier = Procureurs_immobiliers::where('id_procureur', $jugements_procureur->procureurs_id_procureur)->where('id_immobilier', $immobilier->num_immobilier)->first();
                if(!empty($procureur_immobilier)) {
                    $procureur = Procureur::where('id_procureur', $procureur_immobilier->id_procureur)->first();

                    $atraf3[$procureur->nom_procureur]=$procureur_immobilier->pourcentage;
                }
            }
            foreach ($jugements_defendeurs->all() as $jugements_defendeur){
                $defendeur_immobilier = Defendeurs_immobiliers::where('id_defendeur', $jugements_defendeur->defendeurs_id_defendeur)->where('id_immobilier', $immobilier->num_immobilier)->first();

                if (!empty($defendeur_immobilier)) {
                    $defendeur = Defendeur::where('id_defendeur', $defendeur_immobilier->id_defendeur)->first();
                    $atraf3[$defendeur->nom_defendeur] = $defendeur_immobilier->pourcentage;
                }
            }


            $arrivants=Arrivant::where('id_immobilier',$immobilier->num_immobilier)->get();
            foreach ($arrivants as $arrivant){
                $atraf3[$arrivant->nom_arrivant]=$arrivant->pourcentage;
            }
            $t=0;
            foreach ($atraf3 as $n => $value) {
                $t++;
                $table->addRow();
                $table->addCell(3000, $fancyTableCellStyle)->addText(htmlspecialchars($value, ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "center"));
                $table->addCell(3000, $fancyTableCellStyle)->addText(htmlspecialchars($n, ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "center"));
                $table->addCell(2000, $fancyTableCellStyle)->addText(htmlspecialchars($t, ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "center"));

            }
//        =================================================================== page 11 ==========================================
            $section7 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);


            $section7->addText(htmlspecialchars("واجهة العقار موضوع النزاع موضحة في الصورة  التالية :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>1000], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 3));;
            $table = $section7->addTable(['width' => 50 * 50, 'unit' => 'pct', 'align' => 'center']);
            $table->addRow();
            $table->addCell()->addImage($path . "$immobilier->img_immobilier", [
                'align' => 'center',
            ]);

        }
        //        ==========================================================  ====================================
        $section7 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;

        $firstRowStyle = array('bgColor' => 'ffad00','borderSize' => 19);
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
        $table = $section7->addTable('myTable');
        $table->addRow();
        $table->addCell('9600')->addText(htmlspecialchars('التهيئة تصميم مقتضيات -5', ENT_COMPAT, 'UTF-8'), array('size' => 48, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.2));
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        //        ==========================================================  ====================================

        foreach ($immobilier1 as $j1=>$immobilier) {
            $j1++;
            $tableStyle13 = array(
                'align' => 'right',
                'cellMargin'=>(0|130|0|0)
            );
            $firstRowStyle13 = array();
            if($num_list>1) {
                $phpWord->addTableStyle('myTable13', $tableStyle13, $firstRowStyle13);
                $table3 = $section7->addTable('myTable13');
                $table3->addRow();
                $table3->addCell('10010')->addText(htmlspecialchars(':'.$immobilier->num_immobilier.' عدد العقاري الرسم ذي الخبرة موضوع للعقار بالنسبة- ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                $table3->addCell('750',['bgColor' => '#c00000', 'borderSize' => 21])->addText(htmlspecialchars('5-' . $j1, ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation' => ['left' => 20, 'right' => 20]));
            }
            $rc = Reports_contents::where('num_dossier', $request->num_dossier)->where('num_immobilier',$immobilier->num_immobilier)->get();
            if (!empty($rc)) {
                $j=0;
                foreach ($rc as $c) {
                    $rci = Reports_contents_imgs::where('id_report_content', $c->id)->get();

                    if ($c->titre!=null) {
                        $j++;
                        $tableStyle6 = array(
                            'align' => 'right',
                            'cellMargin' => (0 | 130 | 0 | 0)

                        );
                        $firstRowStyle6 = array();
                        $phpWord->addTableStyle('myTable6', $tableStyle6, $firstRowStyle6);
                        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
                        $table3 = $section7->addTable('myTable6');

                        //stt
                        $cc = 1;
                        if ($num_list > 1) {
                            $section7->addText(htmlspecialchars( $j. '-' .$j1  . '-5' . ' ' . '- ' . $c->titre, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial', 'color' => '#0070c0'), array("align" => "right", 'space' => ['before' => 100, 'after' => 100], 'indentation' => ['left' => 540, 'right' => 540]));;
                            $cc++;
                        }else{
                            $table3->addRow();
                            $table3->addCell('8010')->addText(htmlspecialchars("- $c->titre  ", ENT_COMPAT, 'UTF-8'), array('size' => 19, 'rtl' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                            $table3->addCell('750', $styleCell)->addText(htmlspecialchars('5-' . $j, ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                            $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation' => ['left' => 20, 'right' => 20]));
                        }

                    }
                    if (!empty($c->contents)){
                        $section7->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;

                        $section7->addText("$c->contents", array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                    }
                    if (!empty($rci)) {
                        foreach ($rci as $i) {
                            if (!empty($i->name)) {
                                $table = $section7->addTable(['unit' => 'pct', 'align' => 'center']);
                                $dir_path = rtrim(public_path(), 'public') . 'scripts/uploads/pictures/';
                                $data = getimagesize($dir_path . "$i->name");
                                $width = $data[0];
                                $height = $data[1];
                                $table->addRow();
                                $table->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'lineHeight' => 1));;
                                if ($height > 407) {
                                    $table->addCell()->addImage($path . "$i->name", [
                                        'align' => 'center',
                                        'width' => 619.464567

                                    ]);
                                } else {
                                    $table->addCell()->addImage($path . "$i->name", [
                                        'align' => 'center',

                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }

        //        ==========================================================  ====================================

//        ========================================================== page 12 ===============================================
        $section8 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);

        $section8->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $section8->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $section8->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section8->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section8->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section8->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section8->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section8->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section8->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;

        $firstRowStyle = array('bgColor' => 'ffad00','borderSize' => 19);
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle);
        $table = $section8->addTable('myTable');
        $table->addRow();
        $table->addCell('9600')->addText(htmlspecialchars('العقار سوق دراسة-6', ENT_COMPAT, 'UTF-8'), array('size' => 48, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1));
//   ===================================== =================== page 13 ===============================================================
        $section9 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);

        $tableStyle9 = array(
            'align' => 'right',
            'cellMargin'=>(0|130|0|0)

        );
        $firstRowStyle9 = array();
        $phpWord->addTableStyle('myTable9', $tableStyle9, $firstRowStyle9);
        $table3 = $section9->addTable('myTable9');
        $table3->addRow();
        $table3->addCell('8010')->addText(htmlspecialchars(':2017 سنة من الرابع الفصل خلال العقار لسوق العام التوجه - ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial','color'=>'c00000'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
        $table3->addCell('750',['bgColor' => '#c00000','borderSize' => 21])->addText(htmlspecialchars('6-1', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri','color'=>'FFFFFF'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
        $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation'=>['left'=>20,'right'=>20]));
        $section9->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;


        $section9->addText(htmlspecialchars("سجل مؤشر أسعار الأصول العقارية انخفاضا بنسبة %1,3 من فصل لآخر، نتيجة تراجع أسعار العقارات السكنية بنسبة %1,7 والأراضي الحضرية بنسبة %1,2، بينما شهدت أسعار العقارات المخصصة للاستعمال المهني ارتفاعا بنسبة .%3,4 وفيما يتعلق بالمعاملات، فقد تراجع عددها بنسبة %2,4، مع انخفاض مبيعات العقارات السكنية بنسبة %8,6، فيما تزايدت مبيعات الأراضي الحضرية والعقارات المخصصة للاستعمال المهني بنسبة %20,7 و%1,2  على التوالي .", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $section9->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $section9->addText(htmlspecialchars("على أساس سنوي، ارتفعت أسعار الأصول العقارية بنسبة %0,9، حيث ارتفعت أسعار الأراضي الحضرية بنسبة %1,8 والعقارات المخصصة للاستعمال المهني بنسبة %4,4، فيما سجل استقرار في أسعار العقارات السكنية. وانخفض عدد المبيعات بنسبة %11,2، حيث تراجع بواقع %13,2 بالنسبة للعقارات السكنية و%2,5 بالنسبة للأراضي  الحضرية  و%16  بالنسبة للعقارات المخصصة للاستعمال المهني .", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $section9->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
//        $section9->addText(htmlspecialchars("وعلى أساس سنوي، ارتفعت الأسعار بنسبة %6,2 نتيجة لتزايد أثمنه العقارات السكنية بنسبة %7,0 والأراضي الحضرية بنسبة %5 والأصول المخصصة للاستعمال المهني بنسبة .%6,9", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
//        $section9->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
//        $section9->addText(htmlspecialchars("وانخفضت المعاملات من جهتها بنسبة %1,3، حيث تدنت مبيعات العقارات السكنية بنسبة %0,3 والأراضي الحضرية بنسبة %8,1 وارتفعت تلك الخاصة بالأصول الموجهة للاستعمال المهني بنسبة .%6,4", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;

        //    =================================================== page 14 ============================================
        $section10 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);

        $table = $section10->addTable(['borderSize'=>25,'borderColor' => 'C09200', 'unit' => 'pct', 'align' => 'center']);

//        $table3->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
//        $table3->addCell()->addImage($path.'tableau1.jpg');
//        $table3->addRow();
//        $table3->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
//        $table3->addCell()->addImage($path.'tableau2.jpg');
        $cellRowSpan = array('vMerge' => 'restart');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 2);

        $table->addRow();
//        $table->addCell(2000, $cellRowSpan)->addText("1");
//        $table->addCell(2000, $cellRowSpan)->addText("2");
//        $path=public_path('pictures/');
        $table->addCell(5000, $cellColSpan)->addText("(%)التغير",array('size' => 16, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.15));
        $c=$table->addCell(3000, $cellRowSpan);
        $c->addText("الأصول أسعار مؤشر",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.15));
        $c->addText("العقارية ",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.15));
        $table->addRow();
//        $table->addCell(null, $cellRowContinue);
//        $table->addCell(null, $cellRowContinue);
        $c2=$table->addCell(2500,['bgColor' => 'fde4d0']);
        $c2->addText("ف 4-17/",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1,15));
        $c2->addText("ف 4-16",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1,15));
        $c1=$table->addCell(2500,['bgColor' => 'fde4d0']);
        $c1->addText("ف 4-17/",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1,15));
        $c1->addText("ف 3-17",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1,15));
        $table->addCell(null, $cellRowContinue);

        $table->addRow();
        $cell1=$table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f1.png',[
            'align' => 'center']);
        $cell1->addText("0,9",array('size' => 14, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell= $table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f.png',[
            'align' => 'center']);
        $cell->addText("-1,3",array('size' => 14, 'bold' => true, 'name' => 'arial'));;

        $table->addCell(2000,['borderTopSize'=>0])->addText("الإجمالي",array('size' => 14, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addText("0,0",array('size' => 14, 'bold' => false, 'name' => 'calibri'), array("align" => "center"));;
        $cell= $table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f.png',[
            'align' => 'center']);
        $cell->addText("-1,7",array('size' => 14, 'bold' => false, 'name' => 'calibri'), array("align" => "center"));;

        $table->addCell(2000,['bgColor' => 'fde4d0'])->addText("العقارات السكنية",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f1.png',[
            'align' => 'center']);
        $cell1->addText("0,7",array('size' => 14,  'name' => 'calibri'), array("align" => "center"));;
        $cell= $table->addCell(2000,['align'=>'centre'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f.png',[
            'align' => 'center']);
        $cell->addText("-1,9",array('size' => 14, 'bold' => false, 'name' => 'calibri'), array("align" => "center"));;

        $table->addCell(2000,['borderTopSize'=>0])->addText("الشقق",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f.png',[
            'align' => 'center']);
        $cell1->addText("-2,9",array('size' => 14, 'name' => 'arial'), array("align" => "center"));;
        $cell= $table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f.png',[
            'align' => 'center']);
        $cell->addText("-2,2",array('size' => 14,  'name' => 'calibri'), array("align" => "center"));;

        $table->addCell(2000,['bgColor' => 'fde4d0'])->addText("المنازل",array('size' => 14,  'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f.png',[
            'align' => 'center']);
        $cell1->addText("-2,6",array('size' => 14, 'name' => 'arial'), array("align" => "center"));;
        $cell= $table->addCell(2000,['align'=>'centre'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f.png',[
            'align' => 'center']);
        $cell->addText("-1,4",array('size' => 14,  'name' => 'arial'), array("align" => "center"));;

        $table->addCell(2000,['borderTopSize'=>0])->addText("الفيلات",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f1.png',[
            'align' => 'center']);
        $cell1->addText("1,8",array('size' => 14,  'name' => 'arial'), array("align" => "center"));;
        $cell= $table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f.png',[
            'align' => 'center']);
        $cell->addText("-1,2",array('size' => 14,  'name' => 'arial'), array("align" => "center"));;

        $table->addCell(2000,['bgColor' => 'fde4d0'])->addText("الأراضي الحضرية",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f1.png',[
            'align' => 'center']);
        $cell1->addText("4,4",array('size' => 14,  'name' => 'arial'), array("align" => "center"));;
        $cell= $table->addCell(2000,['align'=>'centre'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f1.png',[
            'align' => 'center']);
        $cell->addText("3,4",array('size' => 14, 'name' => 'calibri'), array("align" => "center"));;

        $table->addCell(2000)->addText("العقارات التجارية",array('size' => 14,  'name' => 'calibri'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f1.png',[
            'align' => 'center']);
        $cell1->addText("2,1",array('size' => 14,  'name' => 'calibri'), array("align" => "center"));;
        $cell= $table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f1.png',[
            'align' => 'center']);
        $cell->addText("3,6",array('size' => 14,  'name' => 'calibri'), array("align" => "center"));;

        $table->addCell(2000,['bgColor' => 'fde4d0'])->addText("المحلات التجارية",array('size' => 14, 'rtl'=>true,'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f1.png',[
            'align' => 'center']);
        $cell1->addText("14,0",array('size' => 14,  'name' => 'calibri'), array("align" => "center"));;
        $cell= $table->addCell(2000,['align'=>'centre'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f1.png',[
            'align' => 'center']);
        $cell->addText("1,9",array('size' => 14,  'name' => 'arial'), array("align" => "center"));;

        $table->addCell(2000,['borderTopSize'=>0])->addText("المكاتب",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1));;

        $section10->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $section10->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $table = $section10->addTable(['borderSize'=>25,'borderColor' => 'C09200', 'unit' => 'pct', 'align' => 'center']);

//        $table3->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
//        $table3->addCell()->addImage($path.'tableau1.jpg');
//        $table3->addRow();
//        $table3->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
//        $table3->addCell()->addImage($path.'tableau2.jpg');
        $cellRowSpan = array('vMerge' => 'restart');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 2);

        $table->addRow();
//        $table->addCell(2000, $cellRowSpan)->addText("1");
//        $table->addCell(2000, $cellRowSpan)->addText("2");
//        $path=public_path('pictures/');
        $table->addCell(5000, $cellColSpan)->addText("(%)التغير",array('size' => 16, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.15));
        $c=$table->addCell(3000, $cellRowSpan);
        $c->addText("الأصول أسعار مؤشر",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.15));
        $c->addText("العقارية ",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.15));

        $table->addRow();
//        $table->addCell(null, $cellRowContinue);
//        $table->addCell(null, $cellRowContinue);
        $c2=$table->addCell(2500,['bgColor' => 'fde4d0']);
        $c2->addText("ف 4-17/",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1,15));
        $c2->addText("ف 4-16",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1,15));
        $c1=$table->addCell(2500,['bgColor' => 'fde4d0']);
        $c1->addText("ف 4-17/",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1,15));
        $c1->addText("ف 3-17",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1,15));
        $table->addCell(null, $cellRowContinue);

        $table->addRow();
        $cell1=$table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f.png',[
            'align' => 'center']);
        $cell1->addText("-11,2",array('size' => 14, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell= $table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f.png',[
            'align' => 'center']);
        $cell->addText("-2,4",array('size' => 14, 'bold' => true, 'name' => 'arial'));;

        $table->addCell(2000,['borderTopSize'=>0])->addText("الإجمالي",array('size' => 14, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f.png',[
            'align' => 'center']);
        $cell1->addText("-13,2",array('size' => 14, 'bold' => false, 'name' => 'calibri'), array("align" => "center"));;
        $cell= $table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f.png',[
            'align' => 'center']);
        $cell->addText("-8,6",array('size' => 14, 'bold' => false, 'name' => 'calibri'), array("align" => "center"));;

        $table->addCell(2000,['bgColor' => 'fde4d0'])->addText("العقارات السكنية",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f.png',[
            'align' => 'center']);
        $cell1->addText("-12,2",array('size' => 14,  'name' => 'calibri'), array("align" => "center"));;
        $cell= $table->addCell(2000,['align'=>'centre'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f.png',[
            'align' => 'center']);
        $cell->addText("-9,1",array('size' => 14, 'bold' => false, 'name' => 'calibri'), array("align" => "center"));;

        $table->addCell(2000,['borderTopSize'=>0])->addText("الشقق",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f.png',[
            'align' => 'center']);
        $cell1->addText("-24,8",array('size' => 14, 'name' => 'arial'), array("align" => "center"));;
        $cell= $table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f.png',[
            'align' => 'center']);
        $cell->addText("-2,6",array('size' => 14,  'name' => 'calibri'), array("align" => "center"));;

        $table->addCell(2000,['bgColor' => 'fde4d0'])->addText("المنازل",array('size' => 14,  'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f.png',[
            'align' => 'center']);
        $cell1->addText("-22,9",array('size' => 14, 'name' => 'arial'), array("align" => "center"));;
        $cell= $table->addCell(2000,['align'=>'centre'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f1.png',[
            'align' => 'center']);
        $cell->addText("-0,5",array('size' => 14,  'name' => 'arial'), array("align" => "center"));;

        $table->addCell(2000,['borderTopSize'=>0])->addText("الفيلات",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f.png',[
            'align' => 'center']);
        $cell1->addText("-2,5",array('size' => 14, 'name' => 'arial'), array("align" => "center"));;
        $cell= $table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f1.png',[
            'align' => 'center']);
        $cell->addText("20,7",array('size' => 14,  'name' => 'arial'), array("align" => "center"));;

        $table->addCell(2000,['bgColor' => 'fde4d0'])->addText("الأراضي الحضرية",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f.png',[
            'align' => 'center']);
        $cell1->addText("-16,0",array('size' => 14,  'name' => 'arial'), array("align" => "center"));;
        $cell= $table->addCell(2000,['align'=>'centre'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f1.png',[
            'align' => 'center']);
        $cell->addText("1,2",array('size' => 14, 'name' => 'calibri'), array("align" => "center"));;

        $table->addCell(2000)->addText("العقارات التجارية",array('size' => 14,  'name' => 'calibri'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f.png',[
            'align' => 'center']);
        $cell1->addText("-13,8",array('size' => 14,  'name' => 'calibri'), array("align" => "center"));;
        $cell= $table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f1.png',[
            'align' => 'center']);
        $cell->addText("1,9",array('size' => 14,  'name' => 'calibri'), array("align" => "center"));;

        $table->addCell(2000,['bgColor' => 'fde4d0'])->addText("المحلات التجارية",array('size' => 14, 'rtl'=>true,'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addImage($path.'f.png',[
            'align' => 'center']);
        $cell1->addText("-29,9",array('size' => 14,  'name' => 'calibri'), array("align" => "center"));;
        $cell= $table->addCell(2000,['align'=>'centre'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addImage($path.'f.png',[
            'align' => 'center']);
        $cell->addText("-3,6",array('size' => 14,  'name' => 'arial'), array("align" => "center"));;

        $table->addCell(2000,['borderTopSize'=>0])->addText("المكاتب",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1));;



//        $table->addCell(2000);
//        $table->addCell(2000);
        //    =================================================== page 15 ============================================
        $section11 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);

        $tableStyle10 = array(
            'align' => 'right',
            'cellMargin'=>(0|130|0|0)

        );
        $firstRowStyle10 = array();
        $phpWord->addTableStyle('myTable10', $tableStyle10, $firstRowStyle10);
        $table11 = $section11->addTable('myTable10');
        $table11->addRow();
        $table11->addCell('8010')->addText(htmlspecialchars(':العقار فئة حسب العام التوجه - ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial','color'=>'c00000'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
        $table11->addCell('750',['bgColor' => '#c00000','borderSize' => 21])->addText(htmlspecialchars('6-2', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri','color'=>'FFFFFF'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
        $table11->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation'=>['left'=>20,'right'=>20]));
        $section11->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));;
        $section11->addText(htmlspecialchars(": السكنية العقارات -6-2-1"."\t", ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => true, 'name' => 'arial','color'=>'#0070c0'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $section11->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 0.5));;
        $section11->addText(htmlspecialchars("يعكس انخفاض أسعار العقارات السكنية، على أساس فصلي، تراجعا بلغ %1,9 بالنسبةللشقق و %2,2 للمنازل و %1,4 للفيلات. وفيما يتعلق بعدد المعاملات ، فقد شمل انخفاضه بالأساس مبيعات الشقق والمنازل، بنسب تصل على التوالي إلى %9,1 و%2,6، فيما تزايد بالنسبة للفيلات بواقع %0,5 من فصل لآخر.", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $section11->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 0.5));;
        $section11->addText(htmlspecialchars("وعلى أساس سنوي، ظل مؤشر أسعار العقارات السكنية مستقرا، مع ارتفاع بنسبة %0,7 في أسعار الشقق وانخفاض قدره %2,9 بالنسبة للمنازل و%2,6  للفيلات. وفيما يتعلق بالمبيعات، فقد تراجع عددها بنسبة  %13,2، نتيجة انخفاض بنسبة %12,2  في مبيعات الشقق و%22,9  للفيلات و%24,8  للمنازل.", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $section11->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 0.5));;
        $section11->addText(htmlspecialchars(": الحضرية الأراضي -6-2-2"."\t", ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => true, 'name' => 'arial','color'=>'#0070c0'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $section11->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 0.5));;
        $section11->addText(htmlspecialchars("على أساس فصلي، تراجعت أسعار الأراضي الحضرية بنسبة %1,2 بعد انخفاضها بنسبة %1,5 في الفصل السابق. بالمقابل، ارتفع عدد المعاملات بنسبة  .%20,7 وعلى أساس سنوي، ارتفع مؤشر أسعار الأراضي الحضرية بنسبة %1,8 وتراجع عدد المعاملات بنسبة .%2,5 ", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $section11->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 0.5));;
        $section11->addText(htmlspecialchars(": التجارية العقارات -6-2-3"."\t", ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => true, 'name' => 'arial','color'=>'#0070c0'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $section11->addText(htmlspecialchars("على أساس فصلي، تزايدت أسعار العقارات المخصصة للاستعمال المهني بنسبة  %3,4،مع ارتفاعات بلغت %3,6 بالنسبة للمحلات التجارية و%1,9  بالنسبة للمكاتب. أما بالنسبة للمعاملات، فقد ارتفع عددها بنسبة %1,2 وشملت ارتفاعا بنسبة %1,9 في مبيعات المحلات التجارية مقابل انخفاض بنسبة  %3,6 في مبيعات المكاتب.", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $section11->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 0.5));;
        $section11->addText(htmlspecialchars("وعلى أساس سنوي، ارتفعت الأسعار بنسبة %4,4 مع نمو بلغ %14 بالنسبة للمكاتب و%2,1  بالنسبة للمحلات التجارية. وسجلت المعاملات انخفاضا بنسبة  %16، يعزى إلى تراجع مبيعات المكاتب بنسبة %29,9 والمحلات التجارية بنسبة .%13,8 ", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $section11->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;


        $table3 = $section11->addTable(['align' => 'centre','unit' => 'pct', 'align' => 'center']);
        $table3->addRow();
        $table3->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $table3->addCell()->addImage($path.'statistique1.png');
        //    =================================================== page 16 ============================================
        $section12 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);
        $section12->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;


        $table3 = $section12->addTable(['align' => 'centre','unit' => 'pct', 'align' => 'center']);
        $table3->addRow();
        $table3->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $table3->addCell()->addImage($path.'statistique2.png');
        $table3->addRow();
        $table3->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $table3->addCell()->addImage($path.'statistique3.png');
// =================================================== page 17 ============================================
        $section13 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);
        $section13->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $table3 = $section13->addTable(['align' => 'centre','unit' => 'pct', 'align' => 'center']);
        $table3->addRow();
        $table3->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $table3->addCell()->addImage($path.'statistique4.png');
        $table3->addRow();
        $table3->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $table3->addCell()->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $table3->addRow();
        $table3->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $table3->addCell()->addImage($path.'statistique6.png');
// =================================================== page 18 ============================================
        $section14 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);
        $section14->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $tableStyle11 = array(
            'align' => 'right',
            'cellMargin'=>(0|130|0|0)

        );
        $firstRowStyle11 = array();
        $phpWord->addTableStyle('myTable11', $tableStyle11, $firstRowStyle11);
        $table3 = $section14->addTable('myTable11');
        $table3->addRow();
        $table3->addCell('8010')->addText(htmlspecialchars(':البيضاء الدار مدينة في العقار سوق توجه - ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial','color'=>'c00000'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
        $table3->addCell('750',['bgColor' => '#c00000','borderSize' => 21])->addText(htmlspecialchars('6-3', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri','color'=>'FFFFFF'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
        $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation'=>['left'=>20,'right'=>20]));
        $section14->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $section14->addText(htmlspecialchars("وعلى صعيد الدار البيضاء، شهدت الأسعار شبه استقرار نتيجة لنمو أثمنه الشقق بنسبة %1,6 وانخفاضها بالنسبة للأراضي والمحلات التجارية بواقع %2,3 و%3,5 على التوالي. وبخصوص المبيعات، فقد ارتفعت بنسبة %4 ارتباطا بالأساس بتنامي المعاملات الخاصة بالشق بنسبة %7,5 وتلك الخاصة بالأراضي بنسبة .%3 وبالمقابل، تراجعت مبيعات المحلات التجارية بنسبة %11,2 مقارنة بالفصل الأول", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $section14->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $table3 = $section14->addTable(['align' => 'centre', 'unit' => 'pct', 'align' => 'center']);
        $table3->addRow();
        $table3->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $table3->addCell()->addImage($path.'statistique5.png');
        // =================================================== page 19 ============================================
        $section15 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);

        $tableStyle12 = array(
            'align' => 'right',
            'cellMargin'=>(0|130|0|0)

        );
        $firstRowStyle12 = array();
        $phpWord->addTableStyle('myTable12', $tableStyle12, $firstRowStyle12);
        $table3 = $section15->addTable('myTable12');
        $table3->addRow();
        $table3->addCell('8010')->addText(htmlspecialchars(':البيضاء الدار مدينة في العقارية الأصول أسعار مؤشر تطور - ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial','color'=>'c00000'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
        $table3->addCell('750',['bgColor' => '#c00000','borderSize' => 21])->addText(htmlspecialchars('6-4', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri','color'=>'FFFFFF'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
        $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation'=>['left'=>20,'right'=>20]));
        $section15->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;

        $table = $section15->addTable(['borderSize'=>25,'borderColor' => 'C09200','unit' => 'pct', 'align' => 'center']);

//        $table3->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
//        $table3->addCell()->addImage($path.'tableau1.jpg');
//        $table3->addRow();
//        $table3->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
//        $table3->addCell()->addImage($path.'tableau2.jpg');
        $cellRowSpan = array('vMerge' => 'restart');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 2);

        $table->addRow();
//        $table->addCell(2000, $cellRowSpan)->addText("1");
//        $table->addCell(2000, $cellRowSpan)->addText("2");
//        $path=public_path('pictures/');
        $table->addCell(5000, $cellColSpan)->addText("(%)التغير",array('size' => 16, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.15));
        $c=$table->addCell(3000, $cellRowSpan);
        $c->addText(" العقار فئة ",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.15));


        $table->addRow();
//        $table->addCell(null, $cellRowContinue);
//        $table->addCell(null, $cellRowContinue);
        $c2=$table->addCell(2500,['bgColor' => 'fde4d0']);
        $c2->addText("المعاملات",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1,15));
        $c2->addText("ف4-17 / ف3-17",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1,15));
        $c1=$table->addCell(2500,['bgColor' => 'fde4d0']);
        $c1->addText("السعر",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1,15));
        $c1->addText("ف4-17 / ف3-17",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1,15));
        $table->addCell(null, $cellRowContinue);

        $table->addRow();
        $cell1=$table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addText("-10,5",array('size' => 14,  'name' => 'calibri'), array("align" => "center"));;
        $cell= $table->addCell(2000,['align'=>'centre'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addText("0,2",array('size' => 14, 'bold' => false, 'name' => 'calibri'), array("align" => "center"));;

        $table->addCell(2000,['borderTopSize'=>0])->addText("شقق",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addText("-5,1",array('size' => 14, 'name' => 'arial'), array("align" => "center"));;
        $cell= $table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addText("-0,5",array('size' => 14,  'name' => 'calibri'), array("align" => "center"));;

        $table->addCell(2000,['bgColor' => 'fde4d0'])->addText("منازل",array('size' => 14,  'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addText("30,8",array('size' => 14, 'name' => 'arial'), array("align" => "center"));;
        $cell= $table->addCell(2000,['align'=>'centre'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addText("-0,2",array('size' => 14,  'name' => 'arial'), array("align" => "center"));;

        $table->addCell(2000,['borderTopSize'=>0])->addText("فيلات",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addText("17,3",array('size' => 14, 'name' => 'arial'), array("align" => "center"));;
        $cell= $table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addText("-2,1",array('size' => 14,  'name' => 'arial'), array("align" => "center"));;

        $table->addCell(2000,['bgColor' => 'fde4d0'])->addText("أراضي حضرية",array('size' => 14, 'rtl' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addText("16,4",array('size' => 14,  'name' => 'arial'), array("align" => "center"));;
        $cell= $table->addCell(2000,['align'=>'centre'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addText("3,5",array('size' => 14, 'name' => 'calibri'), array("align" => "center"));;

        $table->addCell(2000)->addText("تجارية محلات",array('size' => 14,  'name' => 'calibri'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addText("17,8",array('size' => 14,  'name' => 'calibri'), array("align" => "center"));;
        $cell= $table->addCell(2000,['bgColor' => 'fde4d0'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addText("0,2",array('size' => 14,  'name' => 'calibri'), array("align" => "center"));;

        $table->addCell(2000,['bgColor' => 'fde4d0'])->addText("مكاتب",array('size' => 14, 'rtl'=>true,'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5));;
        $table->addRow();
        $cell1=$table->addCell(2000)->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell1->addText("\t",array('bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell1->addText("-6,2",array('size' => 14, 'bold'=>true, 'name' => 'calibri'), array("align" => "center"));;
        $cell= $table->addCell(2000,['align'=>'centre'])->addTextRun(['spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1.5]);
        $cell->addText("\t",array('size' => 18, 'bold' => true, 'name' => 'arial'), array("align" => "center"));;
        $cell->addText("-0,1",array('size' => 14, 'bold'=>true, 'name' => 'arial'), array("align" => "center"));;

        $table->addCell(2000,['borderTopSize'=>0])->addText("المجموع",array('size' => 16, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 0,'lineHeight' => 1));;
        $section15->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section15->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $textrun1 = $section15->addTextRun(array('marginRight'=>10,'marginLeft'=>3500,'align'=>'right','space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540]));
        $styleFont = array('bold'=>true, 'size'=>16, 'name'=>'arial');
        $styleFont2 = array('bold'=>true, 'size'=>14, 'name'=>'arial');
        $textrun1->addLink("www.bkam.ma","www.bkam.ma",['size'=>'14','color'=>'#0000FF','bold'=>true,'underline'=>'single','name'=>'calibri'],['align'=>'right']);
        $textrun1->addText(" :المصدر", $styleFont2);



        //        ========================================================== page 20 ===============================================
        $section16 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);

        $section16->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $section16->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $section16->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section16->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section16->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section16->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section16->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section16->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section16->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;

        $firstRowStyle16 = array('bgColor' => 'FEC200','borderSize' => 19);
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle16);
        $table = $section16->addTable('myTable');
        $table->addRow();

        $table->addCell('7600')->addText(htmlspecialchars('العقار وصف -7', ENT_COMPAT, 'UTF-8'), array('size' => 48, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));

//   ========================================================= page 21 ===============================================================
        $list_bat_m=[1=>'أول',2=>'ثاني',3=>'ثالث',4=>'رابع',5=>'خامس',6=>'سادس',7=>'سابع',8=>'ثامن',9=>'تاسع',10=>'عاشر'];
        $list_bat_f=[1=>'أولى',2=>'ثانية',3=>'ثالثة',4=>'رابعة',5=>'خامسة',6=>'سادسة',7=>'سابعة',8=>'ثامنة',9=>'تاسعة',10=>'عاشرة'];
        $m=0;
        foreach($immobilier1 as $immobilier) {
            $somme_etage1=0;
            $m++;
            $surface=$immobilier->surface;
            $immobilier_nature=Immobiliers_natures::where('immobiliers_num_immobilier',$immobilier->num_immobilier)->first();
            $nature=Nature::where('id_nature',$immobilier_nature->natures_id_nature)->first();
            $batiments=Batiment::where('immobiliers_num_immobilier',$immobilier->num_immobilier)->get();
            $louer=$batiments[0]->louer;
            $fermer=$batiments[0]->fermer;
            $prix=$batiments[0]->prix_location;
            $description=$batiments[0]->description;
            //rrrrrrrrrrrrrrrrrrrrrrrrrrrrr
            $somme_sous_batiment1=0;
            foreach ($batiments as $batiment) {
                $etages_bt[] = $batiment->designation_etage;
            }
            // affichage des etage qui constitue l'immeuble
            $etages_bt = array_unique($etages_bt);

            $arr_batiment2 = [];

            foreach ($etages_bt as $z => $etage) {
                $batiment1 = Batiment::where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('designation_etage', $etage)->get();
                $arr_batiment2[$etage] = $batiment1->all();
            }
            foreach ($arr_batiment2 as $z => $bats){
                if(count($bats) == 1){
                    if ($bats[0]->louer == 0 || $bats[0]->louer == null) {
                        if ($bats[0]->fermer == 0 || $bats[0]->fermer == null) {
                            if ($bats[0]->designation_batiment == 'شـقة') {
                                $somme_sous_batiment1=0;
                                $bt = Batiment::where('designation_batiment', $bats[0]->designation_batiment)->where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('ref_batiment', $bats[0]->ref_batiment)->first();
                                $sous_batiment = Sous_batiment::where('ref_batiment', 'LIKE', $bt->ref_batiment)->get();
                                foreach ($sous_batiment as $u){
                                    $somme_sous_batiment1 = $somme_sous_batiment1 + $u->surface;
                                }
                                $somme_etage1= $somme_etage1+$somme_sous_batiment1;

                            }else{
                                $somme_etage1 = $somme_etage1 + $bats[0]->surface;

                            }
                        }else{
                            if($bats[0]->designation_batiment=='شـقة') {
                                $somme_etage1=$somme_etage1+$bats[0]->surface;
                            }else{
                                $somme_etage1=$somme_etage1+$bats[0]->surface;

                            }
                        }
                    }
                    //affichage des batiment qui se trouve dans les etages

                }else {
//                    $somme_batiment1=0;
                    foreach ($bats as $b) {
                        if ($b->louer == 0 || $b->louer == null) {
                            if ($b->fermer == 0 || $b->fermer == null) {
                                if($b->designation_batiment=='شـقة') {
                                    $somme_sous_batiment1=0;
                                    $sous_batiment = Sous_batiment::where('ref_batiment', 'LIKE', $b->ref_batiment)->get();
                                    foreach ($sous_batiment as $sb) {
                                        $somme_sous_batiment1 = $somme_sous_batiment1 + $sb->surface;

                                    }
                                    $somme_etage1= $somme_etage1+$somme_sous_batiment1;
                                }else{
                                    $somme_etage1 = $somme_etage1 + $b->surface;

                                }
                            } else {
                                if($b->designation_batiment=='شـقة') {
                                    $somme_etage1=$somme_etage1+$b->surface;
                                }else{
                                    $somme_etage1=$somme_etage1+$b->surface;

                                }
//                                $somme_batiment1 = $somme_batiment1 + $b->surface;
//                                $somme_etage1 = $somme_etage1 + $b->surface;

                            }
                        }
                    }
                }
            }


            //rrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
            $section17 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);
            $tableStyle13 = array(
                'align' => 'right',
                'cellMargin'=>(0|130|0|0)
            );
            $firstRowStyle13 = array();
            if($num_list>1) {
                $phpWord->addTableStyle('myTable13', $tableStyle13, $firstRowStyle13);
                $table3 = $section17->addTable('myTable13');
                $table3->addRow();
                $table3->addCell('10010')->addText(htmlspecialchars(':'.$immobilier->num_immobilier.' عدد العقاري الرسم ذي الخبرة موضوع للعقار بالنسبة- ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                $table3->addCell('750',['bgColor' => '#c00000', 'borderSize' => 21])->addText(htmlspecialchars('7-' . $m, ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation' => ['left' => 20, 'right' => 20]));
            }
//marker6
            $suf=$batiments[0]->surface;
            $g=$batiments[0]->img_batiment;
            if($nature->designation_nature != 'عمارة') {

                if ($fermer == 1) {
                    $section17->addText(htmlspecialchars("بعد وصولنا إلى العقار موضوع الخبرة، وجدناه مغلقا ولم نتمكن من الدخول إلى داخل العقار موضوع الخبرة قصد معاينته.", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                    if(!empty($g)) {
                        $section17->addText(htmlspecialchars(" العقار  مساحته حوالي " . "²m" . " $surface " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                        $table3 = $section17->addTable(['unit' => 'pct', 'align' => 'center']);
                        $table3->addRow();
                        $table3->addCell('7000')->addImage($path . "$g", [
                            'align' => 'center',
                            'height' => 407,
                            'width' => 407
                        ]);
                    }else{
                        $section17->addText(htmlspecialchars(" العقار  مساحته حوالي " . "²m" . " $surface ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                    }
                    if (!empty($immobilier->description)) {
                        $section17->addText(htmlspecialchars($immobilier->description, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "distribute", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                    }
                }
                if($louer == 1) {
                    if ($nature->designation_nature == 'شقة' || $nature->designation_nature == 'أرض') {
                        $section17->addText(htmlspecialchars("العقار موضوع الخبرة عبارة عن " . $nature->designation_nature . " مكترية بمبلغ " . $prix . " درهم " . "$description .", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                    } else {
                        $section17->addText(htmlspecialchars("العقار موضوع الخبرة عبارة عن " . $nature->designation_nature . " مكتري بمبلغ " . $prix . " درهم " . "$description ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                    }
//                    if(!empty($g)) {
//                        $section17->addText(htmlspecialchars(" العقار  مساحته حوالي " . "²m" . " $suf " . " (أنظر الصورة)", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
//                        $table3 = $section17->addTable(['unit' => 'pct', 'align' => 'center']);
//                        $table3->addRow();
//                        $table3->addCell('7000')->addImage($path . "$g", [
//                            'align' => 'center',
//                            'height' => 407,
//                            'width' => 407
//                        ]);
//                    }else{
                    $section17->addText(htmlspecialchars(" العقار  مساحته حوالي " . "²m" . " $suf ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
//                    }
                }

                if ($louer == 0 || $louer == null) {
                    if ($fermer == 0 || $fermer == null) {
                        $section17->addText(htmlspecialchars("بعد وصولنا إلى العقار موضوع الخبرة، قمنا بمعاينة وتفقد مكونات هذا العقار.", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "distribute", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                        $section17->addText(htmlspecialchars("من خلال هذه المعاينة ، تبين لنا أن العقار موضوع الخبرة هو عبارة عن $nature->designation_nature ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "distribute", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                        if ($nature->designation_nature == 'مكتب') {

                            $section17->addText(htmlspecialchars('ب' . $immobilier->designation_etage . " مساحته حوالي ²m " . $surface . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                        }
                        if ($nature->designation_nature == 'شقة') {
                            $section17->addText(htmlspecialchars(' سكنية ' . 'بالطابق ' . $immobilier->designation_etage . " مساحتها حوالي ²m " . $surface . " وتتكون من : ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                        }
                        if ($nature->designation_nature == 'محل تجاري' || $nature->designation_nature == 'مخزن' || $nature->designation_nature == 'محل صـناعي') {
                            $section17->addText(htmlspecialchars('بالطابق ' . $immobilier->designation_etage . " مساحته حوالي ²m " . $surface . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                        }
                        if ($nature->designation_nature != 'مكتب' && $nature->designation_nature != 'مخزن' && $nature->designation_nature != 'محل صـناعي' && $nature->designation_nature != 'أرض' && $nature->designation_nature != 'محل تجاري' && $nature->designation_nature != 'شقة') {
                            $section17->addText(htmlspecialchars("مساحتها حوالي ²m $surface وتتكون من :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                        }

                    }

                }
            }
            else{
                $section17->addText(htmlspecialchars("بعد وصولنا إلى العقار موضوع الخبرة، قمنا بمعاينة وتفقد مكونات هذا العقار.", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "distribute", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                $section17->addText(htmlspecialchars("من خلال هذه المعاينة ، تبين لنا أن العقار موضوع الخبرة هو عبارة عن $nature->designation_nature ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "distribute", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                if ($nature->designation_nature == 'مكتب') {

                    $section17->addText(htmlspecialchars('ب' . $immobilier->designation_etage . ' مساحته حوالي '."²m" . $surface . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                }
                if ($nature->designation_nature == 'شقة') {
                    $section17->addText(htmlspecialchars(' سكنية ' . 'بالطابق ' . $immobilier->designation_etage . " مساحتها حوالي ²m " . $surface . " وتتكون من : ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                }
                if ($nature->designation_nature == 'محل تجاري' || $nature->designation_nature == 'مخزن' || $nature->designation_nature == 'محل صـناعي') {
                    $section17->addText(htmlspecialchars('بالطابق ' . $immobilier->designation_etage . ' مساحته حوالي '."²m" . $surface . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                }
                if ($nature->designation_nature != 'مكتب' && $nature->designation_nature != 'مخزن' && $nature->designation_nature != 'محل صـناعي' && $nature->designation_nature != 'أرض' && $nature->designation_nature != 'محل تجاري' && $nature->designation_nature != 'شقة') {
                    $section17->addText(htmlspecialchars(' مساحتها حوالي '."²m"."$somme_etage1 وتتكون من :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                }
            }
            $textrun6 = $section17->addTextRun(array('marginRight'=>70,'marginLeft'=>2500,'align'=>'right','space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));

            $etages=[];
            $b1=[];
            $t1=[];
            $count=0;
            $count1=0;
            $count2=0;
            $ocurence=[];
            $ocurence1=[];
            $temp1=[];
            $ocurence2=[];
            $temp2=[];
//            aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa

            if($nature->designation_nature=='عمارة' || $nature->designation_nature=='فيلا') {
                $somme_sous_batiment=0;
                $somme_etage=0;
                if($immobilier->louer==0){
                    if($immobilier->fermer==0){

                        $styleFont1 = array('rtl' => true, 'size' => 16, 'name' => 'arial');

                        foreach ($batiments as $batiment) {
                            $etages[] = $batiment->designation_etage;
                        }

                        // affichage des etage qui constitue l'immeuble
                        $etages = array_unique($etages);
                        foreach ($etages as $etage) {
                            if (end($etages) == $etage) {
                                $textrun6->addText($etage . '. ', $styleFont1);

                            } else {
                                $textrun6->addText($etage . '، ', $styleFont1);

                            }
                        }

                        $arr_batiment = [];

                        foreach ($etages as $z => $etage) {
                            $batiment1 = Batiment::where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('designation_etage', $etage)->get();
                            $arr_batiment[$etage] = $batiment1->all();
                        }

                        $c = 0;
                        $c1=0;
                        foreach ($arr_batiment as $z => $bats) {
                            $somme_batiment=0;
                            foreach ($bats as $bat){
                                $somme_batiment= $somme_batiment + $bat->surface;
                            }
                            foreach ($bats as $batiment){
                                $ocurence[$batiment->designation_batiment] = $count;
                                $temp1[$batiment->designation_batiment] = 0;
                                $ocurence2[$batiment->designation_batiment] = $count2;
                                $temp2[$batiment->designation_batiment] = 0;
                            }
                            foreach ($bats as $batiment) {
                                if (array_key_exists("$batiment->designation_batiment", $ocurence)) {
                                    $ocurence[$batiment->designation_batiment] = $ocurence[$batiment->designation_batiment] + 1;

                                }
                                if (array_key_exists("$batiment->designation_batiment", $ocurence2)) {
                                    $ocurence2[$batiment->designation_batiment] = $ocurence2[$batiment->designation_batiment] + 1;

                                }

                            }


                            $c1++;
                            $tableStyle16 = array(
                                'align' => 'right',
                                'cellMargin' => (0 | 130 | 0 | 0)

                            );
                            $firstRowStyle16 = array();
                            $phpWord->addTableStyle('myTable16', $tableStyle16, $firstRowStyle16);
                            if($num_list==1) {
                                $table3 = $section17->addTable('myTable16');
                            }
                            // affichage des etages
                            //st

                            if ($c >= 10) {
                                if($num_list>1){
                                    $section17->addText(htmlspecialchars( $c1.'-'.$m.'-7'.' ' .'- ' . $z, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial','color'=>'#0070c0'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));;

//                                    $table3->addCell('850')->addText(htmlspecialchars( '7-'.$m.'-'.$c1, ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => false, 'name' => 'calibri', 'color' => '#0070c0'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                }else{
                                    $table3->addRow();
                                    $table3->addCell('3000')->addText(htmlspecialchars('- ' . $z, ENT_COMPAT, 'UTF-8'), array('size' => 20, 'rtl' => true, 'name' => 'arial', 'color' => '#c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                    $c++;
                                    $table3->addCell('850', ['bgColor' => '#c00000', 'borderSize' => 21])->addText(htmlspecialchars('7-' . $c, ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                    $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation' => ['left' => 20, 'right' => 20]));

                                }
                            }else {
                                if($num_list>1){
                                    $section17->addText(htmlspecialchars( $c1.'-'.$m.'-7'.' ' .'- ' . $z, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial','color'=>'#0070c0'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));;

//                                    $table3->addCell('850')->addText(htmlspecialchars('7-'.$m.'-'.$c1 , ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => false, 'name' => 'calibri', 'color' => '#0070c0'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                }else{
                                    $table3->addRow();
                                    $table3->addCell('3000')->addText(htmlspecialchars('- ' . $z, ENT_COMPAT, 'UTF-8'), array('size' => 20, 'rtl' => true, 'name' => 'arial', 'color' => '#c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                    $c++;
                                    $table3->addCell('850', ['bgColor' => '#c00000', 'borderSize' => 21])->addText(htmlspecialchars('7-' . $c, ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                    $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation' => ['left' => 20, 'right' => 20]));

                                }
                            }
                            //==============================================================================================
                            $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;

                            $textrun7 = $section17->addTextRun(array('marginRight' => 70, 'marginLeft' => 2500, 'align' => 'right','spacing'=>100,'indentation'=>['left'=>540,'right'=>540]));
//                            $textrun7->addText($somme_batiment, $styleFont1);

                            if (count($bats) == 1) {
                                $somme_etage=0;
                                $bt = Batiment::where('designation_batiment', $bats[0]->designation_batiment)->where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('ref_batiment', $bats[0]->ref_batiment)->first();
                                $sous_batiment = Sous_batiment::where('ref_batiment', 'LIKE', $bt->ref_batiment)->get();
                                //affichage des batiment qui se trouve dans les etages

                                if (!empty($sous_batiment->all())) {
                                    if($bats[0]->designation_batiment=='شـقة'){
                                        $somme_sous_batiment=0;
                                        foreach($sous_batiment as $x){
                                            $somme_sous_batiment=$somme_sous_batiment+$x->surface;
                                        }
                                        $textrun7->addText($z.' مساحته '."²m".$somme_sous_batiment. ' يتكون من ', $styleFont1);
                                        $somme_etage=$somme_etage+$somme_sous_batiment;
                                    }else{
                                        $textrun7->addText($z.' مساحته '."²m".$bats[0]->surface. ' يتكون من ', $styleFont1);
                                        $somme_etage=$somme_etage+$bats[0]->surface;
                                    }
                                }else {
                                    //$section17->addText(htmlspecialchars("bb", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 0.1));;
                                    if($bats[0]->louer==0 || $bats[0]->louer==null){
                                        if($bats[0]->fermer==0 || $bats[0]->fermer==null){
                                            $textrun7->addText($z.' مساحته '."²m".$bats[0]->surface. ' يتكون من :', $styleFont1);
                                            $somme_etage=$somme_etage+$bats[0]->surface;
                                        }else{
                                            $textrun7->addText($z.' مساحته '."²m".$bats[0]->surface . ' يتكون من ', $styleFont1);
                                            $somme_etage=$somme_etage+$bats[0]->surface;

                                        }
                                    }else{
                                        $textrun7->addText($z. ' يتكون من ', $styleFont1);

                                    }
                                }
                            }else {
                                $somme_etage=0;
                                $somme_batiment=0;
                                foreach ($bats as $b){
                                    if($b->louer==0 || $b->louer==null) {
                                        if ($b->fermer == 0 || $b->fermer == null){
                                            if($b->designation_batiment=='شـقة'){
                                                $somme_sous_batiment=0;
                                                $sous_batiment = Sous_batiment::where('ref_batiment', 'LIKE', $b->ref_batiment)->get();
                                                foreach ($sous_batiment as $sb){
                                                    $somme_sous_batiment = $somme_sous_batiment + $sb->surface;
                                                }

//                                                $somme_batiment = $somme_batiment + $somme_sous_batiment;
                                                $somme_etage = $somme_etage + $somme_sous_batiment;
                                            }else{
                                                $somme_etage = $somme_etage + $b->surface;
                                            }
                                        } else {

                                            $somme_etage = $somme_etage + $b->surface;

                                        }
                                    }
                                }
                                $textrun7->addText($z.' مساحته '."²m".$somme_etage . ' يتكون من ', $styleFont1);
                            }

                            $i = 1;
                            $dif = '';

                            foreach ($bats as $bat) {
                                if (array_key_exists("$bat->designation_batiment", $ocurence)) {
//
                                    $temp1[$bat->designation_batiment] = $temp1[$bat->designation_batiment] + 1;
                                }

                                // si nb batiment (> 1 )
                                //check1
                                if (count($bats) > 1) {
                                    if(end($bats) == $bat) {
                                        if (preg_match('#شـقة#', $bat->designation_batiment) == 1 || preg_match('#غرفة#', $bat->designation_batiment) == 1) {
                                            if ($ocurence[$bat->designation_batiment] > 1) {
                                                $dba1 = $list_bat_f[$temp1[$bat->designation_batiment]];
                                                $textrun7->addText(' ' . $bat->designation_batiment . " $dba1 " . '. ', $styleFont1);
                                            } else {
                                                $textrun7->addText(' ' . $bat->designation_batiment . '. ', $styleFont1);

                                            }
                                        } else {
                                            if ($ocurence[$bat->designation_batiment] > 1) {
                                                $dba1 = $list_bat_m[$temp1[$bat->designation_batiment]];
                                                $textrun7->addText(' ' . $bat->designation_batiment . " $dba1 " . '. ', $styleFont1);
                                            } else {
                                                $textrun7->addText(' ' . $bat->designation_batiment . '. ', $styleFont1);

                                            }
                                        }
                                    } else {
                                        if (preg_match('#شـقة#', $bat->designation_batiment) == 1 || preg_match('#غرفة#', $bat->designation_batiment) == 1) {
                                            if ($ocurence[$bat->designation_batiment] > 1) {
                                                $dba1 = $list_bat_f[$temp1[$bat->designation_batiment]];
                                                $textrun7->addText(' ' . $bat->designation_batiment . " $dba1 " . ' و', $styleFont1);
                                            } else {
                                                $textrun7->addText(' ' . $bat->designation_batiment . ' و', $styleFont1);

                                            }
                                        } else {
                                            if ($ocurence[$bat->designation_batiment] > 1) {
                                                $dba1 = $list_bat_m[$temp1[$bat->designation_batiment]];
                                                $textrun7->addText(' ' . $bat->designation_batiment . " $dba1 " . ' و', $styleFont1);
                                            } else {
                                                $textrun7->addText(' ' . $bat->designation_batiment . ' و', $styleFont1);

                                            }

                                        }
                                    }
                                }
// si nb batiments =1
                                //check

                                if (count($bats) == 1) {
                                    $bt = Batiment::where('designation_batiment', $bat->designation_batiment)->where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('ref_batiment', $bat->ref_batiment)->first();
                                    $sous_batiment = Sous_batiment::where('ref_batiment', 'LIKE', $bt->ref_batiment)->get();
                                    $somme_sous_batiment=0;
                                    foreach($sous_batiment as $x){
                                        $somme_sous_batiment=$somme_sous_batiment+$x->surface;
                                    }
                                    if (!empty($sous_batiment->all())) {

                                        $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 0.5));;

                                        if (preg_match('#شـقة#', $bat->designation_batiment) == 1) {
                                            if ($bat->fermer == '0' || $bat->fermer == null) {
                                                if(abs($bat->surface - 0.0)>0.00001) {

                                                    $textrun7->addText(' ' . $bat->designation_batiment.' مساحتها حوالي '."²m".$somme_sous_batiment.' '.$bat->description, $styleFont1);
                                                }else{

                                                    $textrun7->addText(' ' . $bat->designation_batiment.' '.$bat->description, $styleFont1);

                                                }
                                                $textrun7->addText(' وهي تتكون من :', $styleFont1);
                                            } else {
                                                if(abs($bat->surface - 0.0)>0.00001) {
                                                    $textrun7->addText(' ' . $bat->designation_batiment.' مساحتها حوالي '."²m".$bat->surface.' '.$bat->description, $styleFont1);
                                                }else{
                                                    $textrun7->addText(' ' . $bat->designation_batiment.' '.$bat->description, $styleFont1);

                                                }

                                                $textrun7->addText(' وهي مغلقة', $styleFont1);

                                            }

                                        }else {
                                            //bt=1
                                            if ($bat->fermer == '0' || $bat->fermer == null) {
                                                if(abs($bat->surface - 0.0)>0.00001) {
                                                    if (!empty($bat->img_batiment)){
                                                        $textrun7->addText(' ' . $bat->designation_batiment.' مساحته حوالي '."²m".$bat->surface.' '.$bat->description." (أنظر الصورة) :", $styleFont1);
                                                    }else{
                                                        $textrun7->addText(' ' . $bat->designation_batiment.' مساحته حوالي '."²m".$bat->surface.' '.$bat->description, $styleFont1);
                                                    }
                                                }else{
                                                    if (!empty($bat->img_batiment)){
                                                        $textrun7->addText(' ' . $bat->designation_batiment.' '.$bat->description." (أنظر الصورة) :", $styleFont1);
                                                    }else{
                                                        $textrun7->addText(' ' . $bat->designation_batiment.' '.$bat->description, $styleFont1);
                                                    }

                                                }
                                                if (!empty($bat->img_batiment)) {
                                                    $table = $section17->addTable(['width' => 50 * 50, 'unit' => 'pct', 'align' => 'center']);

                                                    $dir_path=rtrim(public_path(),'public').'scripts/uploads/pictures/';
                                                    $data = getimagesize($dir_path."$bat->img_batiment");
                                                    $width = $data[0];
                                                    $height = $data[1];
                                                    $table->addRow();
                                                    $table->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'lineHeight' => 1));;
                                                    if($height > 407) {
                                                        $table->addCell()->addImage($path . "$bat->img_batiment", [
                                                            'align' => 'center',
                                                            'height' => 407,

                                                        ]);
                                                    }else{
                                                        $table->addCell()->addImage($path . "$bat->img_batiment", [
                                                            'align' => 'center',

                                                        ]);
                                                    }
                                                }
                                                $section17->addText(htmlspecialchars(  ' وهو يتكون من :', ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                            } else {
                                                if(abs($bat->surface - 0.0)>0.00001) {
                                                    $textrun7->addText(' ' . $bat->designation_batiment.' مساحته حوالي '."²m".$bat->surface.' '.$bat->description.' '.$bat->description, $styleFont1);
                                                }else{
                                                    $textrun7->addText(' ' . $bat->designation_batiment, $styleFont1);

                                                }


                                                $textrun7->addText(' وهو مغلق', $styleFont1);

                                            }
                                        }
                                    }
                                }

                            }


                            $bt1 = [];

                            foreach ($bats as $f => $bat) {
                                if (array_key_exists("$bat->designation_batiment", $ocurence)) {
                                    $temp2[$bat->designation_batiment] = $temp2[$bat->designation_batiment] + 1;
                                }
                                $f++;
                                $b = explode(' ', $bat->designation_batiment);
                                $tableStyle17 = array(
                                    'align' => 'right',
                                    'cellMargin' => (0 | 130 | 0 | 0)

                                );
                                $firstRowStyle17 = array();
                                $phpWord->addTableStyle('myTable17', $tableStyle17, $firstRowStyle17);
//                                $table3 = $section17->addTable('myTable17');
//                                    if ($bat->designation_batiment != 'غرفة' && $bat->designation_batiment != 'سطح' && $bat->designation_batiment != 'مرحاض' && $bat->designation_batiment != 'مطبخ' && $bat->designation_batiment != 'حمام' && $bat->designation_batiment != 'صالون') {
                                if (count($bats) > 1) {

//                                    $table3->addRow();
                                    if (preg_match('#شـقة#', $bat->designation_batiment) == 1 || preg_match('#غرفة#', $bat->designation_batiment) == 1) {
                                        if ($ocurence2[$bat->designation_batiment] > 1) {
                                            $dba1 = $list_bat_f[$temp2[$bat->designation_batiment]];
//                                            $table3->addCell('8010')->addText(htmlspecialchars(' - ' . "ال" . $bat->designation_batiment . " ال" . $dba1, ENT_COMPAT, 'UTF-8'), array('size' => 20, 'rtl' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                            if($num_list>1){
                                                $section17->addText(htmlspecialchars(  $f.'-'.$c1. '-'.$m.'-'.'7-'.' '. "ال" . $bat->designation_batiment . " ال" . $dba1, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial','color'=>'##00B056'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));;
                                            }else{
                                                $section17->addText(htmlspecialchars(   $f. '-' . $c . '-'.'7-'.' '. "ال" . $bat->designation_batiment . " ال" . $dba1, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial','color'=>'#0070c0'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));;
                                            }
                                        } else {
                                            if($num_list>1){
                                                $section17->addText(htmlspecialchars($f.'-'.$c1. '-'.$m.'-'.'7-'.' '. "ال" . $bat->designation_batiment, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial','color'=>'##00B056'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));;
//                                                $table3->addCell('8010')->addText(htmlspecialchars('7-' . $m . '-'.$c1.'-'. $f.' '. "ال" . $bat->designation_batiment, ENT_COMPAT, 'UTF-8'), array('size' => 20, 'rtl' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                            }else{
                                                $section17->addText(htmlspecialchars( $f. '-' . $c . '-'.'7-'.' '. "ال" . $bat->designation_batiment, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial','color'=>'#0070c0'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));;
//                                                $table3->addCell('8010')->addText(htmlspecialchars( $c . '-' . $f . '-'.'7-'.' '. "ال" . $bat->designation_batiment, ENT_COMPAT, 'UTF-8'), array('size' => 20, 'rtl' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));
                                            }
                                        }
                                    } else {
                                        if (preg_match('#محل تجاري#', $bat->designation_batiment) == 1) {
                                            $designation_bati = explode(' ', $bat->designation_batiment);

                                            if ($ocurence2[$bat->designation_batiment] > 1) {
                                                $dba1 = $list_bat_m[$temp2[$bat->designation_batiment]];
                                                if($num_list>1) {
//                                                    $table3->addCell('8010')->addText(htmlspecialchars(' - ' . "ال" . $designation_bati[0] . " ال" . $designation_bati[1] . " ال" . $dba1, ENT_COMPAT, 'UTF-8'), array('size' => 20, 'rtl' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                                    $section17->addText(htmlspecialchars($f.'-'.$c1. '-'.$m.'-'.'7-'.' '. "ال" . $designation_bati[0] . " ال" . $designation_bati[1] . " ال" . $dba1, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial','color'=>'##00B056'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));;

                                                }else{
                                                    $section17->addText(htmlspecialchars(  $f . '-' . $c. '-'.'7-'.' '. "ال" . $designation_bati[0] . " ال" . $designation_bati[1] . " ال" . $dba1, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial','color'=>'#0070c0'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));;
                                                }
                                            } else {
                                                if($num_list>1) {
                                                    $section17->addText(htmlspecialchars( $f.'-'.$c1. '-'.$m.'-'.'7-'.' ' . "ال" . $designation_bati[0] . " ال" . $designation_bati[1], ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial','color'=>'#00B056'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));;
//                                                    $table3->addCell('8010')->addText(htmlspecialchars(' - ' . "ال" . $designation_bati[0] . " ال" . $designation_bati[1], ENT_COMPAT, 'UTF-8'), array('size' => 20, 'rtl' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                                }else{
                                                    $section17->addText(htmlspecialchars(  $f. '-' . $c. '-'.'7-'.' '. "ال" . $designation_bati[0] . " ال" . $designation_bati[1], ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial','color'=>'#0070c0'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));;
                                                }
                                            }
                                        }else{
                                            if ($ocurence2[$bat->designation_batiment] > 1) {
                                                $dba1 = $list_bat_m[$temp2[$bat->designation_batiment]];
                                                if($num_list>1){
                                                    $section17->addText(htmlspecialchars(   $f.'-'.$c1. '-'.$m.'-'.'7-'.' ' . "ال" . $bat->designation_batiment . " ال" . $dba1, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial','color'=>'#00B056'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));;
                                                }else{
                                                    $section17->addText(htmlspecialchars(   $f. '-' .$c. '-'.'7-'.' ' . "ال" . $bat->designation_batiment, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial','color'=>'#0070c0'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));;
                                                }
//                                                $table3->addCell('8010')->addText(htmlspecialchars(' - ' . "ال" . $bat->designation_batiment . " ال" . $dba1, ENT_COMPAT, 'UTF-8'), array('size' => 20, 'rtl' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                            } else {
                                                if($num_list>1){
                                                    $section17->addText(htmlspecialchars( $f.'-'.$c1. '-'.$m.'-'.'7-'.' ' . "ال" . $bat->designation_batiment, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial','color'=>'#00B056'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));;
                                                }else{
                                                    $section17->addText(htmlspecialchars(  $f. '-' .$c. '-'.'7-'.' ' . "ال" . $bat->designation_batiment, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'rtl' => true, 'name' => 'arial','color'=>'#0070c0'), array("align" => "right",'space'=>['before'=>100,'after'=>100],'indentation'=>['left'=>540,'right'=>540]));;
                                                }
//                                                $table3->addCell('8010')->addText(htmlspecialchars(' - ' . "ال" . $bat->designation_batiment, ENT_COMPAT, 'UTF-8'), array('size' => 20, 'rtl' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                            }
                                        }
                                    }
                                    //st
//                                    if($num_list>1){
//                                        $table3->addCell('1350', ['bgColor' => '#c00000', 'borderSize' => 21])->addText(htmlspecialchars('7-' . $m . '-'.$c1.'-'. $f, ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
//                                    }else{
//                                        $section17->addText(htmlspecialchars('7-' . $c . '-', ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => true, 'name' => 'arial','color'=>'#0070c0'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
////                                        $table3->addCell('1050', ['bgColor' => '#c00000', 'borderSize' => 21])->addText(htmlspecialchars('7-' . $c . '-' . $f, ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
//                                    }
//                                    $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation' => ['left' => 20, 'right' => 20]));
                                }
                                $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
                                $somme_sous_batiment=0;
                                $bt = Batiment::where('designation_batiment', $bat->designation_batiment)->where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('ref_batiment', $bat->ref_batiment)->first();
                                $sous_batiment = Sous_batiment::where('ref_batiment', 'LIKE', $bt->ref_batiment)->get();
                                foreach($sous_batiment as $x){
                                    $somme_sous_batiment=$somme_sous_batiment+$x->surface;
                                }
                                //affichage de pludieurs batiements non louer et non fermer d'un etage
                                if (count($bats) > 1) {
                                    if (!empty($sous_batiment->all())) {
                                        if (preg_match('#شـقة#', $bat->designation_batiment) == 1) {
                                            $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment. " مساحتها حوالي " . "²m".$somme_sous_batiment . " تتكون من :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                        } else {
                                            $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment . " يتكون من :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                                        }
                                    }
                                }
                                $sf = $bat->surface;

                                $temp = [];
                                if (!empty($sous_batiment->all())) {
                                    foreach ($sous_batiment->all() as $it) {
                                        $ocurence1[$it->designation] = $count1;
                                        $temp[$it->designation] = 0;
                                    }
                                    foreach ($sous_batiment->all() as $it) {
                                        if (array_key_exists("$it->designation", $ocurence1)) {
                                            $ocurence1[$it->designation] = $ocurence1[$it->designation] + 1;
                                        }
                                    }
                                }
                                if(empty($sous_batiment->all())) {
                                    if ($bat->louer == 0 || $bat->louer ==null) {
                                        if ($bat->fermer == 0 || $bat->fermer == null) {
                                            if (preg_match('#غرفة#', $bat->designation_batiment) == 1 || preg_match('#شرفة#', $bat->designation_batiment) == 1 || preg_match('#ساحة#', $bat->designation_batiment) == 1 || preg_match('#شـقة#', $bat->designation_batiment) == 1) {

                                                $section17->addText(htmlspecialchars($bat->designation_batiment . " مساحتها حوالي " . "²m $sf" . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                            } else {
                                                $section17->addText(htmlspecialchars($bat->designation_batiment . " مساحته حوالي " . "²m $sf" . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                            }

                                            if ($bat->description != null) {
                                                $section17->addText(htmlspecialchars($bat->description, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                            }
                                            if (!empty($bat->img_batiment)) {
                                                $table = $section17->addTable(['width' => 50 * 50, 'unit' => 'pct', 'align' => 'center']);

                                                $dir_path=rtrim(public_path(),'public').'scripts/uploads/pictures/';
                                                $data = getimagesize($dir_path."$bat->img_batiment");
                                                $width = $data[0];
                                                $height = $data[1];
                                                $table->addRow();
                                                $table->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'lineHeight' => 1));;
                                                if($height > 407) {
                                                    $table->addCell()->addImage($path . "$bat->img_batiment", [
                                                        'align' => 'center',
                                                        'height' => 407,

                                                    ]);
                                                }else{
                                                    $table->addCell()->addImage($path . "$bat->img_batiment", [
                                                        'align' => 'center',

                                                    ]);
                                                }
                                            }
//mark1
                                        }else {
                                            if(count($bats)==1) {
                                                if ($bat->designation_batiment == 'شـقة' || $bat->designation_batiment == 'غرفة') {
                                                    if(!empty($bat->img_batiment)) {
//============================================================================================
                                                        $textrun7->addText($bat->designation_batiment . " مغلقة " . "مساحتها حوالي " . "²m" . "$bat->surface". " (أنظر الصورة) :", $styleFont1);
//                                                        $section17->addText(htmlspecialchars(" يتكون منxx " . $bat->designation_batiment . " مغلقة " . " مساحتها حوالي " . "²m" . " $bat->surface ". " (أنظر الصورة)", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 1, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                                    }else{
                                                        $textrun7->addText($bat->designation_batiment . " مغلقة " . "مساحتها حوالي " . "²m" . "$bat->surface", $styleFont1);
//                                                        $section17->addText(htmlspecialchars(" يتكون منxx " . $bat->designation_batiment . " مغلقة " . " مساحتها حوالي " . "²m" . " $bat->surface ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 1, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                                                    }
                                                } else {
                                                    if(!empty($bat->img_batiment)) {
                                                        $textrun7->addText($bat->designation_batiment . " مغلق " . " مساحته حوالي " . "²m" . " $bat->surface ". " (أنظر الصورة) :", $styleFont1);

//                                                        $section17->addText(htmlspecialchars(" يتكون من " . $bat->designation_batiment . " مغلق " . " مساحته حوالي " . "²m" . " $bat->surface ". " (أنظر الصورة)", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                                    }else{
                                                        $textrun7->addText($bat->designation_batiment . " مغلق " . " مساحته حوالي " . "²m" . " $bat->surface ", $styleFont1);

//                                                        $section17->addText(htmlspecialchars(" يتكون من " . $bat->designation_batiment . " مغلق " . " مساحته حوالي " . "²m" . " $bat->surface ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                                                    }
                                                }
                                                if (!empty($bat->img_batiment)) {
                                                    $table = $section17->addTable(['width' => 50 * 50, 'unit' => 'pct', 'align' => 'center']);

                                                    $dir_path=rtrim(public_path(),'public').'scripts/uploads/pictures/';
                                                    $data = getimagesize($dir_path."$bat->img_batiment");
                                                    $width = $data[0];
                                                    $height = $data[1];
                                                    $table->addRow();
                                                    $table->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'lineHeight' => 1));;
                                                    if($height > 407) {
                                                        $table->addCell()->addImage($path . "$bat->img_batiment", [
                                                            'align' => 'center',
                                                            'height' => 407,

                                                        ]);
                                                    }else{
                                                        $table->addCell()->addImage($path . "$bat->img_batiment", [
                                                            'align' => 'center',

                                                        ]);
                                                    }

                                                }
                                            }
                                            //batiment fermer cas d'un etage avec plusieur batiment
                                            if(count($bats)>1){
                                                if ($bat->designation_batiment == 'شـقة' || $bat->designation_batiment == 'غرفة') {
                                                    if (!empty($bat->img_batiment)) {
                                                        $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment . " مغلقة " . " مساحتها حوالي " . "²m" . " $bat->surface ". " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                                    }else{
                                                        $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment . " مغلقة " . " مساحتها حوالي " . "²m" . " $bat->surface ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                                    }
                                                } else {
                                                    if (!empty($bat->img_batiment)) {
                                                        $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment . " مغلق " . " مساحته حوالي " . "²m" . " $bat->surface ". " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                                    }else{
                                                        $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment . " مغلق " . " مساحته حوالي " . "²m" . " $bat->surface ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                                    }
                                                }
                                                if (!empty($bat->img_batiment)) {
                                                    $table = $section17->addTable(['width' => 50 * 50, 'unit' => 'pct', 'align' => 'center']);

                                                    $dir_path=rtrim(public_path(),'public').'scripts/uploads/pictures/';
                                                    $data = getimagesize($dir_path."$bat->img_batiment");
                                                    $width = $data[0];
                                                    $height = $data[1];
                                                    $table->addRow();
                                                    $table->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'lineHeight' => 1));;
                                                    if($height > 407) {
                                                        $table->addCell()->addImage($path . "$bat->img_batiment", [
                                                            'align' => 'center',
                                                            'height' => 407,

                                                        ]);
                                                    }else{
                                                        $table->addCell()->addImage($path . "$bat->img_batiment", [
                                                            'align' => 'center',

                                                        ]);
                                                    }

                                                }
                                            }
//                                $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment . " مغلق ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                                        }
                                    }else{
                                        if(count($bats)==1){
                                            if ($bat->designation_batiment == 'شـقة' || $bat->designation_batiment == 'غرفة') {

                                                $textrun7->addText(htmlspecialchars( $bat->designation_batiment . " مكتراة شهريا بمبلغ ".$bat->prix_location.' درهم '.$bat->description, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'));;
                                            } else {
                                                $section17->addText(htmlspecialchars( $bat->designation_batiment . " مكتري شهريا بمبلغ ".$bat->prix_location.' درهم '.$bat->description, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'));;

                                            }}
                                        //check5
                                        if(count($bats)>1) {
                                            if ($bat->designation_batiment == 'شـقة' || $bat->designation_batiment == 'غرفة') {

                                                $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment . " مكتراة شهريا بمبلغ ".$bat->prix_location.' درهم '.$bat->description, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                            } else {
                                                $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment . " مكتري شهريا بمبلغ ".$bat->prix_location.' درهم '.$bat->description, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                                            }
                                        }
                                    }

//                                            $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;

                                } else{
//                        $section17->addText(htmlspecialchars($bat->designation_batiment . " يتكون من :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                    if ($bat->fermer == 0) {
                                        //p4

                                        $table3 = $section17->addTable(['unit' => 'pct', 'align' => 'center']);
//p33
                                        foreach ($sous_batiment->all() as $pc => $it) {

                                            if (array_key_exists("$it->designation", $ocurence1)) {
//
//                                                    $ocurence1[$it->designation] = $ocurence1[$it->designation] +1;

                                                $temp[$it->designation] = $temp[$it->designation] + 1;
                                            }
//                                            if($ocurence1[$it->designation]>1){
//                                                $ocurence1[$it->designation]=$ocurence1[$it->designation]-1;
//                                            }

                                            $table3->addRow();
//            sous batiment n'est pas fermer
                                            if ($it->fermer == 0) {
//                                                        sous batiment louer
                                                if (!empty($it->louer)) {
                                                    if (preg_match('#غرفة#', $it->designation) == 1 || preg_match('#شرفة#', $it->designation) == 1 || preg_match('#ساحة#', $it->designation) == 1) {
                                                        if ($ocurence1[$it->designation] > 1) {

                                                            $dba = $list_bat_f[$temp[$it->designation]];

                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . " مكتراة شهريا بمبلغ " . $it->prix_location . " درهم " . "$it->description" . ".", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                        } else {
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . " مكتراة شهريا بمبلغ " . $it->prix_location . " درهم " . "$it->description" . ".", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                        }
                                                    } else {

                                                        if ($ocurence1[$it->designation] > 1) {
                                                            $dba = $list_bat_m[$temp[$it->designation]];

                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . " مكتري شهريا بمبلغ " . $it->prix_location . " درهم " . "$it->description" . ".", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                        } else {
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . " مكتري شهريا بمبلغ " . $it->prix_location . " درهم " . "$it->description" . ".", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                        }
                                                    }
                                                    $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                                                } else {
                                                    if (preg_match('#غرفة#', $it->designation) == 1 || preg_match('#شرفة#', $it->designation) == 1 || preg_match('#ساحة#', $it->designation) == 1) {
                                                        $dba = $list_bat_f[$temp[$it->designation]];
                                                        if ($ocurence1[$it->designation] > 1) {
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مساحتها حوالي " . "²m" . $it->surface . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                        } else {
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مساحتها حوالي " . "²m" . $it->surface . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                        }
                                                    } else {

                                                        $dba = $list_bat_m[$temp[$it->designation]];
                                                        if ($ocurence1[$it->designation] > 1) {
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مساحته حوالي " . "²m" . $it->surface . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                        } else {
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مساحته حوالي " . "²m" . $it->surface . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                        }
                                                    }
                                                    $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                                                    //sa
                                                    if (!empty($it->img)) {
                                                        $dir_path = rtrim(public_path(), 'public') . 'scripts/uploads/pictures/';
                                                        $data = getimagesize($dir_path . "$it->img");
                                                        $width = $data[0];
                                                        $height = $data[1];
                                                        $table3->addRow();
                                                        if ($height > 407) {
                                                            $table3->addCell('7000')->addImage($path . "$it->img", [
                                                                'align' => 'center',
                                                                'height' => 407,

                                                            ]);
                                                        } else {
                                                            $table3->addCell('7000')->addImage($path . "$it->img", [
                                                                'align' => 'center',
                                                            ]);
                                                        }
                                                        $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;

                                                    }
                                                }
                                            } else {
//close
                                                if (preg_match('#غرفة#', $it->designation) == 1 || preg_match('#شرفة#', $it->designation) == 1 || preg_match('#ساحة#', $it->designation) == 1) {
                                                    if ($ocurence1[$it->designation] > 1) {
                                                        $dba = $list_bat_f[$temp[$it->designation]];
                                                        if (!empty($it->img)) {
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . " مغلقة " . "$it->description" . " مساحتها حوالي " . "²m" . $it->surface . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                        } else {
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . " مغلقة " . "$it->description" . " مساحتها حوالي " . "²m" . $it->surface, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                        }
                                                    } else {
                                                        if (!empty($it->img)) {
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . " مغلقة " . "$it->description" . " مساحتها حوالي " . "²m" . $it->surface . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                        } else {
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . " مغلقة " . "$it->description" . " مساحتها حوالي " . "²m" . $it->surface, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                        }
                                                    }
                                                } else {
                                                    if ($ocurence1[$it->designation] > 1) {
                                                        $dba = $list_bat_m[$temp[$it->designation]];
                                                        if (!empty($it->img)) {
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مغلق " . " مساحته حوالي " . "²m" . $it->surface . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                        } else {
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مغلق " . " مساحته حوالي " . "²m" . $it->surface, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                        }
                                                    } else {
                                                        if (!empty($it->img)) {
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مغلق " . " مساحته حوالي " . "²m" . $it->surface . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                        } else {
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مغلق " . " مساحته حوالي " . "²m" . $it->surface, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                        }
                                                    }
                                                }
                                                $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                                                if (!empty($it->img)) {
                                                    $dir_path=rtrim(public_path(),'public').'scripts/uploads/pictures/';
                                                    $data = getimagesize($dir_path."$it->img");
                                                    $width = $data[0];
                                                    $height = $data[1];
                                                    $table3->addRow();
                                                    if($height > 407) {
                                                        $table3->addCell('7000')->addImage($path . "$it->img", [
                                                            'align' => 'center',
                                                            'height' => 407,

                                                        ]);
                                                    }else{
                                                        $table3->addCell('7000')->addImage($path . "$it->img", [
                                                            'align' => 'center',
                                                        ]);
                                                    }
                                                    $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
                                                }
                                            }

                                        }
                                    }
                                }
                            }
//                                    else {
//                                        $table3 = $section17->addTable(['unit' => 'pct', 'align' => 'center']);
//                                        $table3->addRow();
//                                        if ($bat->surface != null) {
////                                    //p1
//
//                                            if (preg_match('#غرفة#', $bat->designation_batiment) == 1 || preg_match('#شرفة#', $bat->designation_batiment) == 1 || preg_match('#ساحة#', $bat->designation_batiment) == 1) {
//                                                if ($ocurence2[$bat->designation_batiment] > 1) {
//                                                    $dba1 = $list_bat_f[$temp2[$bat->designation_batiment]];
//                                                    $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$bat->designation_batiment " . $dba1 . "$bat->description" . " مساحتها حوالي " . "²m" . $bat->surface . " (أنظر الصورة)", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
//                                                } else {
//                                                    $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$bat->designation_batiment " . "$bat->description" . " مساحتها حوالي " . "²m" . $bat->surface . " (أنظر الصورة)", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
//
//                                                }
//                                            } else {
//                                                if ($ocurence2[$bat->designation_batiment] > 1) {
//                                                    $dba1 = $list_bat_m[$temp2[$bat->designation_batiment]];
//                                                    $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$bat->designation_batiment " . $dba1 . "$bat->description" . " مساحته حوالي " . "²m" . $bat->surface . " (أنظر الصورة)", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
//                                                } else {
//                                                    $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$bat->designation_batiment " . "$bat->description" . " مساحته حوالي " . $bat->surface . "²m" . " (أنظر الصورة)", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
//
//                                                }
//                                            }
//                                        } else {
//                                            $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$bat->designation_batiment " . "$bat->description" . " (أنظر الصورة)", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
//
//                                        }
//                                        $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
//                                        $table3->addRow();
//                                        $table3->addCell('7000')->addImage($path . "$bat->img_batiment", [
//                                            'align' => 'center',
//                                            'height' => 407,
//                                            'width' => 407
//                                        ]);

//

//                        $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 0.5));;


//
                        }

                        //p2

//bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb
//                            $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;


                    }
                }
            }
//            dd($somme_etage);
            if($nature->designation_nature=='مكتب') {
                if($immobilier->fermer==0 || $immobilier->louer==0) {
                    foreach ($batiments as $b){
                        $table = $section17->addTable(['width' => 50 * 50, 'unit' => 'pct', 'align' => 'center']);
                        $table->addRow();
                        $table->addCell('700')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;

                        $table->addCell()->addImage($path . "$b->img_batiment", [
                            'align' => 'center',
                            'height' => 330
                        ]);
                    }
                }


            }
            if($nature->designation_nature=='أرض') {
                $textrun = $section17->addTextRun(array('marginRight'=>70,'marginLeft'=>2500,'align'=>'right','spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));

                if($immobilier->fermer==0) {

                    foreach ($batiments as $v) {
                        $b1[] = $v->designation_batiment;
                        $t1[] = $v;
                    }
                    $b1 = array_unique($b1);
                    foreach ($b1 as $x => $c) {
                        if ($c == 'بناء') {
                            $b1[$x] = 'بنايات';
                        }
                        if ($c == 'بئر') {
                            $b1[$x] = 'آبار';
                        }
                    }
                    $textrun->addText('بها ', $styleFont1);

                    foreach ($b1 as $e) {
                        if (end($b1) == $e) {
                            $textrun->addText($e . ': ', $styleFont1);
                        } else {
                            $textrun->addText($e . ' و', $styleFont1);

                        }
                    }
                    $i=1;
                    $table3 = $section17->addTable(['align' => 'right']);
                    $table3->addRow();
                    $table3->addCell('7000')->addText(htmlspecialchars('ال' . $nature->designation_nature.' مساحتها '.$immobilier->surface.' هكتار '.' ( أنظر الصورة):', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'rtl' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                    $table3->addCell('350')->addText(htmlspecialchars('-', ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                    $table3->addCell('450')->addText(htmlspecialchars('7-' . $i, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => true, 'name' => 'calibri', 'color' => 'c00000'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                    $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                    $table = $section17->addTable(['width' => 50 * 50, 'unit' => 'pct', 'align' => 'center']);
                    $table->addRow();
//
                    $table->addCell()->addImage($path . "$immobilier->img_immobilier", [
                        'align' => 'center',
                    ]);
                    $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                    $t2 = [];
//                    $t3 = [];
                    foreach($t1 as $v){
                        if($v->designation_batiment=='بناء'){
                            $t2['بنايات'][]=$v;
                        }
                        if($v->designation_batiment=='بئر'){
                            $t2['آبار'][]=$v;
                        }
                    }

                    foreach ($t2 as $c => $t) {
                        $i++;
                        $table3 = $section17->addTable(['align' => 'right']);
                        $table3->addRow();
                        $table3->addCell('7000')->addText(htmlspecialchars('ال' . $c.' ( أنظر الصورة):', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'rtl' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                        $table3->addCell('350')->addText(htmlspecialchars('-', ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                        $table3->addCell('450')->addText(htmlspecialchars('7-' . $i, ENT_COMPAT, 'UTF-8'), array('size' => 16, 'bold' => true, 'name' => 'calibri', 'color' => 'c00000'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                        $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                        $table = $section17->addTable(['width' => 50 * 50, 'unit' => 'pct', 'align' => 'center']);
                        foreach ($t as $j) {

                            $table->addRow();

                            $table->addCell()->addImage($path . "$j->img_batiment", [
                                'align' => 'center',
                            ]);
                            $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                        }
                        $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                    }

                }
            }
            if($nature->designation_nature=='محل تجاري' || $nature->designation_nature=='مخزن' || $nature->designation_nature=='محل صـناعي'){

                foreach ($batiments as $batiment) {

                    if($batiment->louer==0) {
                        if($batiment->fermer==0){
                            $styleFont1 = array('rtl' => true, 'size' => 16, 'name' => 'arial');

                            foreach ($batiments as $batiment) {
                                $etages[] = $batiment->designation_etage;
                                $ocurence[$batiment->designation_batiment]=$count;

                            }
                            foreach ($batiments as $batiment) {
                                if (array_key_exists("$batiment->designation_batiment", $ocurence)) {
                                    $ocurence[$batiment->designation_batiment] = $ocurence[$batiment->designation_batiment] + 1;

                                }
                            }
                            $etages = array_unique($etages);


                            $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;


                            $arr_batiment = [];

                            foreach ($etages as $z => $etage) {
                                $batiment1 = Batiment::where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('designation_etage', $etage)->get();
                                $arr_batiment[$etage] = $batiment1->all();
                            }

                            $c = 0;

                            foreach ($arr_batiment as $z => $bats) {
                                $c++;
                                $word = explode(' ', $z);

                                $i=1;
                                $dif='';
                                $img=$bats[0]->img_batiment;
                                $table = $section17->addTable(['width' => 50 * 50, 'unit' => 'pct', 'align' => 'center']);
                                $table->addRow();
                                $table->addCell()->addImage($path . "$img", [
                                    'align' => 'center',
                                    'width'=>500
                                ]);



                                $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                $bt1 = [];

                                foreach ($bats as $f => $bat) {
                                    $f++;
                                    $b = explode(' ', $bat->designation_batiment);
                                    $table3 = $section17->addTable(['align' => 'right']);
                                    if (count($bats) > 1) {
//                            sous titre
                                        $table3->addRow();
                                        $table3->addCell('7000')->addText(htmlspecialchars($bat->designation_batiment, ENT_COMPAT, 'UTF-8'), array('size' => 20, 'rtl' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));

                                        $table3->addCell('400')->addText(htmlspecialchars(' - ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                        $table3->addCell('850', ['bgColor' => '#c00000', 'borderSize' => 21])->addText(htmlspecialchars('7-' . $c . '-' . $f, ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                    }

                                    $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                    $sf = $bat->surface;

                                    $temp = [];
                                    $bt = Batiment::where('designation_batiment', $bat->designation_batiment)->where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('ref_batiment', $bat->ref_batiment)->first();
                                    $sous_batiment = Sous_batiment::where('ref_batiment', 'LIKE', $bt->ref_batiment)->get();
                                    if (!empty($sous_batiment->all())) {
                                        foreach ($sous_batiment->all() as $it) {
                                            $ocurence1[$it->designation] = $count1;
                                            $temp[$it->designation] = 0;
                                        }
                                        foreach ($sous_batiment->all() as $it) {
                                            if (array_key_exists("$it->designation", $ocurence1)) {
                                                $ocurence1[$it->designation] = $ocurence1[$it->designation] + 1;
                                            }
                                        }
                                    }

                                    //dd
                                    if(!empty($sous_batiment->all())) {
                                        if ($bat->description != null) {
                                            $section17->addText(htmlspecialchars($bat->description, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                        }
                                        $textrun7 = $section17->addTextRun(array('marginRight' => 70, 'marginLeft' => 2500, 'align' => 'right','space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                        if(count($bats) == 1) {
                                            $textrun7->addText('ال' . $bat->designation_batiment, $styleFont1);
                                            $textrun7->addText(' يتكون من :', $styleFont1);

                                        }
//                        $section17->addText(htmlspecialchars($bat->designation_batiment . " يتكون من :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                        if ($bat->fermer == 1) {
                                            $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment . " مغلق ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                                        } else {
                                            if (count($bats) > 1) {
                                                if ($bat->designation_batiment == 'شقة') {
                                                    $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment . " تتكون من :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                                } else {
                                                    $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment . " يتكون من :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                                                }
                                            }

                                            $table3 = $section17->addTable(['unit' => 'pct', 'align' => 'center']);
//p33
                                            foreach ($sous_batiment->all() as $it) {
                                                if (array_key_exists("$it->designation", $ocurence1)) {
//
//                                                    $ocurence1[$it->designation] = $ocurence1[$it->designation] +1;

                                                    $temp[$it->designation] = $temp[$it->designation] + 1;
                                                }
//                                            if($ocurence1[$it->designation]>1){
//                                                $ocurence1[$it->designation]=$ocurence1[$it->designation]-1;
//                                            }

                                                $table3->addRow();
                                                if ($it->fermer == 0) {
                                                    if (!empty($it->louer)) {
                                                        if (preg_match('#غرفة#', $it->designation) == 1 || preg_match('#شرفة#', $it->designation) == 1 || preg_match('#ساحة#', $it->designation) == 1) {
                                                            if ($ocurence1[$it->designation] > 1) {

                                                                $dba = $list_bat_f[$temp[$it->designation]];

                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – ".$it->designation . " $dba "." $it->description " . " مكتراة شهريا بمبلغ " . $it->prix_location . " درهم " . ".", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – ".$it->designation ." $it->description ". " مكتراة شهريا بمبلغ " . $it->prix_location . " درهم " . ".", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                            }
                                                        } else {

                                                            if ($ocurence1[$it->designation] > 1) {
                                                                $dba = $list_bat_m[$temp[$it->designation]];

                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – ".$it->designation . " $dba "." $it->description ". " مكتري شهريا بمبلغ " . $it->prix_location . " درهم " . ".", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – ".$it->designation ." $it->description ". " مكتري شهريا بمبلغ " . $it->prix_location . " درهم " . ".", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                            }
                                                        }
                                                        $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                                                        if ($it->description != null) {
                                                            $table3->addRow();
                                                            $table3->addCell('7000')->addText(htmlspecialchars($it->description, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            $table3->addCell('400')->addText(htmlspecialchars(" ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                                                        }
                                                    } else {
                                                        if (preg_match('#غرفة#', $it->designation) == 1 || preg_match('#شرفة#', $it->designation) == 1 || preg_match('#ساحة#', $it->designation) == 1) {
                                                            $dba = $list_bat_f[$temp[$it->designation]];
                                                            if ($ocurence1[$it->designation] > 1) {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – ".$it->designation . " $dba "." $it->description ". " مساحتها حوالي " ."²m". $it->surface ." (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – ".$it->designation ." $it->description ". " مساحتها حوالي " ."²m".$it->surface . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                            }
                                                        } else {

                                                            $dba = $list_bat_m[$temp[$it->designation]];
                                                            if ($ocurence1[$it->designation] > 1) {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – ".$it->designation . " $dba "." $it->description ". " مساحته حوالي "."²m". $it->surface . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – ".$it->designation ." $it->description ". " مساحته حوالي " ."²m". $it->surface ." (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                            }
                                                        }
                                                        $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                                                        $table3->addRow();
                                                        $table3->addCell('7000')->addImage($path . "$it->img", [
                                                            'align' => 'center',
                                                            'height' => 320,
                                                            'width'=>475
                                                        ]);
                                                        $table3->addCell('400')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
                                                        $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;

                                                    }
                                                } else {
//
                                                    if (preg_match('#غرفة#', $it->designation) == 1 || preg_match('#شرفة#', $it->designation) == 1 || preg_match('#ساحة#', $it->designation) == 1) {
                                                        if ($ocurence1[$it->designation] > 1) {
                                                            $dba = $list_bat_f[$temp[$it->designation]];
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – ".$it->designation ." $dba". " $it->description " . " مغلقة ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                        }else{
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – ".$it->designation . " $it->description " . " مغلقة ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                        }
                                                    } else {
                                                        if ($ocurence1[$it->designation] > 1) {
                                                            $dba = $list_bat_m[$temp[$it->designation]];
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – ".$it->designation ." $dba". " $it->description " . " مغلق ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                        }else{
                                                            $table3->addCell('7000')->addText(htmlspecialchars(" – ".$it->designation . " $it->description " . " مغلق ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                        }
                                                    }
                                                    $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));

                                                }

                                                $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                                            }
                                        }

                                    }

                                    $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                }
                            }
                        }
//
                    }
//                    die();
                    //p2

//bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb
                    $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;


                }
            }
            if($nature->designation_nature=='شقة'){
                if($batiments[0]->louer==0){
                    if($batiments[0]->fermer==0){
                        $etages1=[];

                        foreach ($batiments as $batiment){
                            $etages1[] = $batiment->designation_etage;
                        }
                        $arr_batiment1=[];
                        $etages1 = array_unique($etages1);

                        foreach ($etages1 as $z => $etage1){
                            $batiment2 = Batiment::where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('designation_etage', $etage1)->get();
                            $arr_batiment1[$etage1] = $batiment2->all();
                        }
                        foreach ($arr_batiment1 as $z => $bats1) {

                            foreach ($bats1 as $f => $bat) {
                                $bt1 = Batiment::where('designation_batiment', $bat->designation_batiment)->where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('ref_batiment', $bat->ref_batiment)->first();
                                $sous_batiment_s = Sous_batiment::where('ref_batiment', 'LIKE', $bt1->ref_batiment)->get();
                                $surface_im=$immobilier->surface;
                                $rest='';
                                $somme_surface=0;
                                $sb_isclose=0;

                                foreach ($sous_batiment_s as $s_b){
                                    $somme_surface=$somme_surface+$s_b->surface;
                                    if($s_b->louer==1) {

                                        $sb_isclose = 1;

                                    }
                                }
                                $somme_surface= round($somme_surface);

                                if($somme_surface>0) {
                                    while (abs((round($somme_surface) - $surface_im) / $somme_surface) > 0.00001) {
                                        if ($sb_isclose == 1) {
                                            break;
                                        }
                                        if ($surface_im > $somme_surface){

                                            $rest = $surface_im - $somme_surface;
                                            $count_s_b_surface = Sous_batiment::whereNotNull('surface')->where('surface', '>', 0)->where('ref_batiment', 'LIKE', $bt1->ref_batiment)->count();
                                            if ($rest < 6) {


                                                $rest = $rest / $count_s_b_surface;

                                                foreach ($sous_batiment_s as $s_b1) {
                                                    $s = $s_b1->surface + $rest;

                                                    $somme_surface = $somme_surface + $rest;
                                                    DB::table('sous_batiments')->where('ref_sous_batiment', $s_b1->ref_sous_batiment)->update(['surface_ajuster' => $s]);
                                                }
//


                                                ;                                            }

                                            if ($rest >= 6){
                                                return redirect()->route('dossier.getDossier')->with('danger', 'هناك خطأ في المساحة');
                                            }
                                        }
                                        if ($surface_im < $somme_surface) {

                                            $rest = $somme_surface - $surface_im;

                                            $count_s_b_surface = Sous_batiment::whereNotNull('surface')->where('surface', '>', 0)->where('ref_batiment', 'LIKE', $bt1->ref_batiment)->count();


                                            if ($rest < 6) {
                                                $rest = $rest / $count_s_b_surface;
                                                foreach ($sous_batiment_s as $s_b1) {
                                                    if ($s_b1->surface > $rest) {
                                                        $s = $s_b1->surface - $rest;
                                                        $somme_surface = $somme_surface - $rest;
                                                    }
                                                    DB::table('sous_batiments')->where('ref_sous_batiment', $s_b1->ref_sous_batiment)->update(['surface_ajuster' => $s]);
                                                }
                                            }
                                            if ($rest > 6) {
                                                return redirect()->route('dossier.getDossier')->with('danger', 'هناك خطأ في المساحة');

                                            }
                                        }

                                    }
                                }else{
                                    $sb_isclose=1;
                                }
                            }
                        }
                        $styleFont1 = array('rtl' => true, 'size' => 16, 'name' => 'arial');

                        foreach($batiments as $batiment){
                            $etages[] = $batiment->designation_etage;
                            $ocurence[$batiment->designation_batiment] = $count;

                        }
                        foreach ($batiments as $batiment){
                            if (array_key_exists("$batiment->designation_batiment", $ocurence)){
                                $ocurence[$batiment->designation_batiment] = $ocurence[$batiment->designation_batiment] + 1;

                            }
                        }
                        $etages = array_unique($etages);

                        $arr_batiment = [];

                        foreach ($etages as $z => $etage) {
                            $batiment1 = Batiment::where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('designation_etage', $etage)->get();
                            $arr_batiment[$etage] = $batiment1->all();
                        }

                        $c = 0;

                        foreach ($arr_batiment as $z => $bats) {
                            $c++;
                            $word = explode(' ', $z);

                            $i = 1;
                            $dif = '';
                            $bt1 = [];

                            foreach ($bats as $f => $bat) {
                                $f++;
                                $b = explode(' ', $bat->designation_batiment);
                                $table3 = $section17->addTable(['align' => 'right']);
                                if (count($bats) > 1) {
//                            sous titre
                                    $table3->addRow();
                                    $table3->addCell('7000')->addText(htmlspecialchars($bat->designation_batiment, ENT_COMPAT, 'UTF-8'), array('size' => 20, 'rtl' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));

                                    $table3->addCell('400')->addText(htmlspecialchars(' - ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                    $table3->addCell('850', ['bgColor' => '#c00000', 'borderSize' => 21])->addText(htmlspecialchars('7-' . $c . '-' . $f, ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                                }

//                            $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                $sf = $bat->surface;

                                $temp = [];
                                $bt = Batiment::where('designation_batiment', $bat->designation_batiment)->where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('ref_batiment', $bat->ref_batiment)->first();
                                $sous_batiment = Sous_batiment::where('ref_batiment', 'LIKE', $bt->ref_batiment)->get();
                                if(!empty($sous_batiment->all())) {
                                    foreach ($sous_batiment->all() as $it) {
                                        $ocurence1[$it->designation] = $count1;
                                        $temp[$it->designation] = 0;
                                    }
                                    foreach ($sous_batiment->all() as $it) {
                                        if (array_key_exists("$it->designation", $ocurence1)) {
                                            $ocurence1[$it->designation] = $ocurence1[$it->designation] + 1;
                                        }
                                    }
                                }

                                //dd
                                if (!empty($sous_batiment->all())) {
                                    if ($bat->description != null) {
                                        $section17->addText(htmlspecialchars($bat->description, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                    }
//                        $section17->addText(htmlspecialchars($bat->designation_batiment . " يتكون من :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                    if ($bat->fermer == 1) {
                                        $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment . " مغلق ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                                    } else {
                                        if (count($bats) > 1) {
                                            if ($bat->designation_batiment == 'شقة') {
                                                $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment . " تتكون من :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
                                            } else {
                                                $section17->addText(htmlspecialchars("ال" . $bat->designation_batiment . " يتكون من :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'space' => ['before' => 50, 'after' => 480], 'indentation' => ['left' => 540, 'right' => 540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                                            }
                                        }

                                        $table3 = $section17->addTable(['unit' => 'pct', 'align' => 'center']);
//p33
                                        $isclose=0;
                                        foreach ($sous_batiment->all() as $cp => $it) {
                                            if ($it->louer == 1) {

                                                $isclose = 1;

                                            }
                                        }
                                        foreach ($sous_batiment->all() as $cp => $it) {


                                            if (array_key_exists("$it->designation", $ocurence1)) {
//
//                                                    $ocurence1[$it->designation] = $ocurence1[$it->designation] +1;

                                                $temp[$it->designation] = $temp[$it->designation] + 1;
                                            }
//                                            if($ocurence1[$it->designation]>1){
//                                                $ocurence1[$it->designation]=$ocurence1[$it->designation]-1;
//                                            }
//marker4
                                            if ($isclose == 0){
                                                $table3->addRow();
                                                if ($it->fermer == 0) {
                                                    if (!empty($it->louer)) {
                                                        if (preg_match('#غرفة#', $it->designation) == 1 || preg_match('#شرفة#', $it->designation) == 1 || preg_match('#ساحة#', $it->designation) == 1) {
                                                            if ($ocurence1[$it->designation] > 1) {
                                                                $dba = $list_bat_f[$temp[$it->designation]];
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مكتراة شهريا بمبلغ " . $it->prix_location . " درهم ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مكتراة شهريا بمبلغ " . $it->prix_location . " درهم ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            }
                                                        } else {
                                                            if ($ocurence1[$it->designation] > 1) {
                                                                $dba = $list_bat_m[$temp[$it->designation]];
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مكتري شهريا بمبلغ " . $it->prix_location . " درهم ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {

                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation" . " $it->description" . " مكتري شهريا بمبلغ " . $it->prix_location . " درهم ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));


                                                            }
                                                        }
                                                        $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));

                                                    } else {
                                                        if (preg_match('#غرفة#', $it->designation) == 1 || preg_match('#شرفة#', $it->designation) == 1 || preg_match('#ساحة#', $it->designation) == 1) {
                                                            $dba = $list_bat_f[$temp[$it->designation]];
                                                            if ($ocurence1[$it->designation] > 1) {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مساحتها حوالي " . "²m" . " $it->surface_ajuster " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مساحتها حوالي " . "²m" . " $it->surface_ajuster " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                            }
                                                        } else {

                                                            $dba = $list_bat_m[$temp[$it->designation]];
                                                            if ($ocurence1[$it->designation] > 1) {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مساحته حوالي " . "²m" . " $it->surface_ajuster " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مساحته حوالي " . "²m" . " $it->surface_ajuster " ." (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                            }
                                                        }
                                                        $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                                                        if (!empty($it->img)) {
                                                            $dir_path=rtrim(public_path(),'public').'scripts/uploads/pictures/';
                                                            $data = getimagesize($dir_path."$it->img");
                                                            $width = $data[0];
                                                            $height = $data[1];
                                                            $table3->addRow();
                                                            if($height > 407) {
                                                                $table3->addCell('7000')->addImage($path . "$it->img", [
                                                                    'align' => 'center',
                                                                    'height' => 407,

                                                                ]);
                                                            }else{
                                                                $table3->addCell('7000')->addImage($path . "$it->img", [
                                                                    'align' => 'center',

                                                                ]);
                                                            }
                                                            $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
                                                        }
                                                    }
                                                } else {
// marker2
                                                    if (preg_match('#غرفة#', $it->designation) == 1 || preg_match('#شرفة#', $it->designation) == 1 || preg_match('#ساحة#', $it->designation) == 1) {
                                                        if ($ocurence1[$it->designation] > 1) {
                                                            $dba = $list_bat_f[$temp[$it->designation]];
                                                            if (!empty($it->img)) {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مغلقة " . " مساحتها حوالي " . "²m" . " $it->surface_ajuster " ." (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مغلقة " . " مساحتها حوالي " . "²m" . " $it->surface_ajuster ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            }
                                                        } else {
                                                            if (!empty($it->img)) {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مغلقة " . " مساحتها حوالي " . "²m" . " $it->surface_ajuster " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مغلقة " . " مساحتها حوالي " . "²m" . " $it->surface_ajuster ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            }
                                                        }
                                                    } else {
                                                        if ($ocurence1[$it->designation] > 1) {
                                                            $dba = $list_bat_m[$temp[$it->designation]];
                                                            if (!empty($it->img)) {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مغلق " . " مساحته حوالي " . "²m" . " $it->surface_ajuster " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مغلق " . " مساحته حوالي " . "²m" . " $it->surface_ajuster ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            }
                                                        } else {
                                                            if (!empty($it->img)) {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مغلق " . " مساحته حوالي " . "²m" . " $it->surface_ajuster " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مغلق " . " مساحته حوالي " . "²m" . " $it->surface_ajuster ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            }
                                                        }
                                                    }
                                                    $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                                                    if (!empty($it->img)) {
                                                        $dir_path=rtrim(public_path(),'public').'scripts/uploads/pictures/';
                                                        $data = getimagesize($dir_path."$it->img");
                                                        $width = $data[0];
                                                        $height = $data[1];
                                                        $table3->addRow();
                                                        if($height > 407) {
                                                            $table3->addCell('7000')->addImage($path . "$it->img", [
                                                                'align' => 'center',
                                                                'height' => 407,

                                                            ]);
                                                        }else{
                                                            $table3->addCell('7000')->addImage($path . "$it->img", [
                                                                'align' => 'center',

                                                            ]);
                                                        }
                                                        $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
                                                    }
                                                }
                                            }else{

                                                $table3->addRow();
                                                if ($it->fermer == 0) {
                                                    if (!empty($it->louer)) {
                                                        if (preg_match('#غرفة#', $it->designation) == 1 || preg_match('#شرفة#', $it->designation) == 1 || preg_match('#ساحة#', $it->designation) == 1) {
                                                            if ($ocurence1[$it->designation] > 1) {
                                                                $dba = $list_bat_f[$temp[$it->designation]];
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مكتراة شهريا بمبلغ " . $it->prix_location . " درهم ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مكتراة شهريا بمبلغ " . $it->prix_location . " درهم ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            }
                                                        } else {
                                                            if ($ocurence1[$it->designation] > 1) {
                                                                $dba = $list_bat_m[$temp[$it->designation]];
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مكتري شهريا بمبلغ " . $it->prix_location . " درهم ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {

                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation" . " $it->description" . " مكتري شهريا بمبلغ " . $it->prix_location . " درهم ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));


                                                            }
                                                        }
                                                        $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));

                                                    } else {
                                                        if (preg_match('#غرفة#', $it->designation) == 1 || preg_match('#شرفة#', $it->designation) == 1 || preg_match('#ساحة#', $it->designation) == 1) {
                                                            $dba = $list_bat_f[$temp[$it->designation]];
                                                            if ($ocurence1[$it->designation] > 1) {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مساحتها حوالي " . "²m" . " $it->surface " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مساحتها حوالي " . "²m" . " $it->surface " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                            }
                                                        } else {

                                                            $dba = $list_bat_m[$temp[$it->designation]];
                                                            if ($ocurence1[$it->designation] > 1) {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مساحته حوالي " . "²m" . " $it->surface " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مساحته حوالي " . "²m" . " $it->surface " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));

                                                            }
                                                        }
                                                        $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                                                        if (!empty($it->img)) {
                                                            $dir_path=rtrim(public_path(),'public').'scripts/uploads/pictures/';
                                                            $data = getimagesize($dir_path."$it->img");
                                                            $width = $data[0];
                                                            $height = $data[1];
                                                            $table3->addRow();
                                                            if($height > 407) {
                                                                $table3->addCell('7000')->addImage($path . "$it->img", [
                                                                    'align' => 'center',
                                                                    'height' => 407,

                                                                ]);
                                                            }else{
                                                                $table3->addCell('7000')->addImage($path . "$it->img", [
                                                                    'align' => 'center',

                                                                ]);
                                                            }
                                                            $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
                                                        }
                                                    }
                                                } else {
// marker2
                                                    if (preg_match('#غرفة#', $it->designation) == 1 || preg_match('#شرفة#', $it->designation) == 1 || preg_match('#ساحة#', $it->designation) == 1) {
                                                        if ($ocurence1[$it->designation] > 1) {
                                                            $dba = $list_bat_f[$temp[$it->designation]];
                                                            if (!empty($it->img)) {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مغلقة " . " مساحتها حوالي " . "²m" . " $it->surface " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مغلقة " . " مساحتها حوالي " . "²m" . " $it->surface ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            }
                                                        } else {
                                                            if (!empty($it->img)) {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مغلقة " . " مساحتها حوالي " . "²m" . " $it->surface " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مغلقة " . " مساحتها حوالي " . "²m" . " $it->surface ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            }
                                                        }
                                                    } else {
                                                        if ($ocurence1[$it->designation] > 1) {
                                                            $dba = $list_bat_m[$temp[$it->designation]];
                                                            if (!empty($it->img)) {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مغلق " . " مساحته حوالي " . "²m" . " $it->surface " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$dba " . "$it->description" . " مغلق " . " مساحته حوالي " . "²m" . " $it->surface ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            }
                                                        } else {
                                                            if (!empty($it->img)) {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مغلق " . " مساحته حوالي " . "²m" . " $it->surface " . " (أنظر الصورة) :", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            } else {
                                                                $table3->addCell('7000')->addText(htmlspecialchars(" – " . "$it->designation " . "$it->description" . " مغلق " . " مساحته حوالي " . "²m" . " $it->surface ", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
                                                            }
                                                        }
                                                    }
                                                    $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                                                    if (!empty($it->img)) {
                                                        $dir_path=rtrim(public_path(),'public').'scripts/uploads/pictures/';
                                                        $data = getimagesize($dir_path."$it->img");
                                                        $width = $data[0];
                                                        $height = $data[1];
                                                        $table3->addRow();
                                                        if($height > 407) {
                                                            $table3->addCell('7000')->addImage($path . "$it->img", [
                                                                'align' => 'center',
                                                                'height' => 407,

                                                            ]);
                                                        }else{
                                                            $table3->addCell('7000')->addImage($path . "$it->img", [
                                                                'align' => 'center',

                                                            ]);
                                                        }
                                                        $table3->addCell('100')->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
                                                    }
                                                }
                                            }

//                                            $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;

                                        }
                                    }

                                }
                            }
                            $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;


//
                        }
//                    die();
                        //p2

//bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb
                        $section17->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;


                    }
                }

            }


        }


//========================================= page 24 =================================

        $section19 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);

        $section19->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $section19->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $section19->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section19->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section19->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section19->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section19->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section19->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section19->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;

        $firstRowStyle16 = array('bgColor' => 'FEF023','borderSize' => 19);
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle16);
        $table = $section19->addTable('myTable');
        $table->addRow();
        $c=$table->addCell('7850');
        $c->addText(htmlspecialchars('قسمة مشاريع تحديد-8', ENT_COMPAT, 'UTF-8'), array('size' => 48, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
        $c->addText(htmlspecialchars('عينية', ENT_COMPAT, 'UTF-8'), array('size' => 48, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
//========================================= page 25 =================================
        //marker1
        foreach ($immobilier1 as $q=>$immobilier){
            $immobilier_nature=Immobiliers_natures::where('immobiliers_num_immobilier',$immobilier->num_immobilier)->first();
            $nature=Nature::where('id_nature',$immobilier_nature->natures_id_nature)->first();
            $batiments=Batiment::where('immobiliers_num_immobilier',$immobilier->num_immobilier)->get();

            $v++;
            $somme_etage3=0;
            $somme_sous_batiment3=0;
            foreach ($batiments as $batiment) {
                $etages_bt2[] = $batiment->designation_etage;
            }
            // affichage des etage qui constitue l'immeuble
            $etages_bt2 = array_unique($etages_bt2);

            $arr_batiment4 = [];

            foreach ($etages_bt2 as $z => $etage) {
                $batiment1 = Batiment::where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('designation_etage', $etage)->get();
                $arr_batiment4[$etage] = $batiment1->all();
            }
            foreach ($arr_batiment4 as $z => $bats){
                if(count($bats) == 1){
                    if ($bats[0]->louer == 0 || $bats[0]->louer == null) {
                        if ($bats[0]->fermer == 0 || $bats[0]->fermer == null) {
                            $somme_sous_batiment3=0;
                            if ($bats[0]->designation_batiment == 'شـقة'){
                                $bt = Batiment::where('designation_batiment', $bats[0]->designation_batiment)->where('immobiliers_num_immobilier', $immobilier->num_immobilier)->where('ref_batiment', $bats[0]->ref_batiment)->first();
                                $sous_batiment = Sous_batiment::where('ref_batiment', 'LIKE', $bt->ref_batiment)->get();
                                foreach ($sous_batiment as $u){
                                    $somme_sous_batiment3 = $somme_sous_batiment3 + $u->surface;
                                }
                                $somme_etage3= $somme_etage3+$somme_sous_batiment3;

                            }else{
                                $somme_etage3 = $somme_etage3 + $bats[0]->surface;

                            }
                        }else{
                            if($bats[0]->designation_batiment=='شـقة') {
                                $somme_etage3=$somme_etage3+$bats[0]->surface;
                            }else{
                                $somme_etage3=$somme_etage3+$bats[0]->surface;

                            }
                        }
                    }
                    //affichage des batiment qui se trouve dans les etages

                }else {
//                    $somme_batiment1=0;
                    foreach ($bats as $b) {
                        if ($b->louer == 0 || $b->louer == null) {
                            if ($b->fermer == 0 || $b->fermer == null) {
                                $somme_sous_batiment3=0;
                                if($b->designation_batiment=='شـقة') {
                                    $sous_batiment = Sous_batiment::where('ref_batiment', 'LIKE', $b->ref_batiment)->get();
                                    foreach ($sous_batiment as $sb) {
                                        $somme_sous_batiment3 = $somme_sous_batiment3 + $sb->surface;

                                    }
                                    $somme_etage3= $somme_etage3+$somme_sous_batiment3;
                                }else{
                                    $somme_etage3 = $somme_etage3 + $b->surface;

                                }
                            } else {
                                if($b->designation_batiment=='شـقة') {
                                    $somme_etage3=$somme_etage3+$b->surface;
                                }else{
                                    $somme_etage3=$somme_etage3+$b->surface;

                                }
//                                $somme_batiment1 = $somme_batiment1 + $b->surface;
//                                $somme_etage1 = $somme_etage1 + $b->surface;

                            }
                        }
                    }
                }
            }
            if($nature->designation_nature=='عمارة' || $nature->designation_nature=='فيلا') {
                $surface1=$somme_etage3;
            }else{
                $surface1=$immobilier->surface;

            }
            $q++;
            $section20 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);
            if($num_list>1) {
                $phpWord->addTableStyle('myTable13', $tableStyle13, $firstRowStyle13);
                $table3 = $section20->addTable('myTable13');
                $table3->addRow();
                $table3->addCell('10010')->addText(htmlspecialchars(':'.$immobilier->num_immobilier.' عدد العقاري الرسم ذي الخبرة موضوع للعقار بالنسبة- ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial', 'color' => 'c00000'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
                $table3->addCell('750', ['bgColor' => '#c00000', 'borderSize' => 21])->addText(htmlspecialchars('6-' . $q, ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri', 'color' => 'FFFFFF'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.15));
                $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation' => ['left' => 20, 'right' => 20]));
            }
            $textrun6 = $section20->addTextRun(array('marginRight' => 70, 'marginLeft' => 2500, 'align' => 'right','space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));
            $styleFont1 = array('rtl' => true, 'size' => 16, 'name' => 'arial');
            $textrun6->addText("حسب شهادة الملكية للملك المسمى", $styleFont1);
            $textrun6->addText('"' . $immobilier->designation_immobilier . '"', $styleFont1);
            $textrun6->addText("ذي الرسم العقاري عدد " . ' ', $styleFont1);

            $textrun6->addText("$immobilier->num_immobilier" . ' ', $styleFont1);
            $textrun6->addText("موضوع الخبرة (أنظر المرفقة رقم 3)، والتي يتبين من خلالها أن مساحة العقار موضوع الخبرة هي ", $styleFont1);
            $textrun6->addText(" $surface1 سنتيار ", $styleFont1);
            $textrun6->addText("وأن عدد الأطراف وأسمائهم ونسب تملكهم في الملك موضوع الخبرة موضح في الجدول التالي:", $styleFont1);
            $immobilier_nature = Immobiliers_natures::where('immobiliers_num_immobilier', $immobilier->num_immobilier)->first();
            $nature = Nature::where('id_nature', $immobilier_nature->natures_id_nature)->first();
            $section20->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 3));;

            $fancyTableStyleName = 'Fancy Table';
            $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000', 'cellMargin' => 0, 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER);
            $fancyTableFirstRowStyle1 = array('bgColor' => 'FFFFFF');
            $fancyTableCellStyle = array('valign' => 'center');

            $phpWord->addTableStyle($fancyTableStyleName, $fancyTableStyle, $fancyTableFirstRowStyle1);
            $table = $section20->addTable($fancyTableStyleName);
            $table->addRow();
            $col3 = $table->addCell(3200, $fancyTableCellStyle);
            $col3->addText(htmlspecialchars('نسبة التملك في الملك المسمى', ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
            $col3->addText(htmlspecialchars(' ذي الرسم "' . $immobilier->designation_immobilier . '"', ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
            $col3->addText(htmlspecialchars(' موضوع ' . "$immobilier->num_immobilier" . 'العقاري عدد، ', ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
            $col3->addText(htmlspecialchars('الخبرة ', ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));
            $table->addCell(4000, $fancyTableCellStyle)->addText(htmlspecialchars('الإسم الكامل', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center"));
            $table->addCell(1500, $fancyTableCellStyle)->addText(htmlspecialchars('العدد  ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'Times New Roman'), array("align" => "center"));


            $atraf3=[];
            foreach ($jugements_procureurs as $u => $jugements_procureur) {
                $procureur_immobilier = Procureurs_immobiliers::where('id_procureur', $jugements_procureur->procureurs_id_procureur)->where('id_immobilier', $immobilier->num_immobilier)->first();
                if(!empty($procureur_immobilier)) {
                    $procureur = Procureur::where('id_procureur', $procureur_immobilier->id_procureur)->first();

                    $atraf3[$procureur->nom_procureur]=$procureur_immobilier->pourcentage;
                }


            }
            foreach ($jugements_defendeurs as $jugements_defendeur) {
                $defendeur_immobilier = Defendeurs_immobiliers::where('id_defendeur', $jugements_defendeur->defendeurs_id_defendeur)->where('id_immobilier', $immobilier->num_immobilier)->first();
                if(!empty($defendeur_immobilier)) {
                    $defendeur = Defendeur::where('id_defendeur', $jugements_defendeur->defendeurs_id_defendeur)->first();

                    $atraf3[$defendeur->nom_defendeur] = $defendeur_immobilier->pourcentage;
                }
            }
            $arrivants=Arrivant::where('id_immobilier',$immobilier->num_immobilier)->get();
            foreach ($arrivants as $arrivant){
                $atraf3[$arrivant->nom_arrivant]=$arrivant->pourcentage;
            }
            $t=0;
            foreach ($atraf3 as $n => $value) {
                $t++;
                $table->addRow();
                $table->addCell(3200, $fancyTableCellStyle)->addText(htmlspecialchars($value, ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "center"));
                $table->addCell(4000, $fancyTableCellStyle)->addText(htmlspecialchars($n, ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "center"));
                $table->addCell(1500, $fancyTableCellStyle)->addText(htmlspecialchars($t, ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "center"));

            }

//           foreach ($atraf as $n => $value) {
//               $table->addRow();
//               $table->addCell(3200, $fancyTableCellStyle)->addText(htmlspecialchars('', ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "center"));
//               $table->addCell(4000, $fancyTableCellStyle)->addText(htmlspecialchars($value, ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "center"));
//               $table->addCell(1500, $fancyTableCellStyle)->addText(htmlspecialchars($n + 1, ENT_COMPAT, 'UTF-8'), array('size' => 14, 'bold' => false, 'name' => 'Times New Roman'), array("align" => "center"));
//
//           }
            $nb_atraf = count($atraf3);
            $section20->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
            $section20->addText(htmlspecialchars("و بما أن:", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1.5));;
            $section20->addText(htmlspecialchars("- العقار موضوع الخبرة عبارة عن:", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>640], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
//            $section20->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
            if($nature->designation_nature=='شقة') {
                $textp25 = "-  العقار موضوع الخبرة عبارة عن $nature->designation_nature" . " سكنية مساحتها حوالي²m" . "$immobilier->surface";
            }
            if($nature->designation_nature=='محل تجاري' || $nature->designation_nature=='مخزن' || $nature->designation_nature=='محل صـناعي' ){
                $textp25 = "-  العقار موضوع الخبرة عبارة عن $nature->designation_nature" . "  مساحته حوالي²m" . "$immobilier->surface";

            }
            if($nature->designation_nature=='فيلا' || $nature->designation_nature=='عمارة') {
                $les_etages=[];
                foreach($batiments as $batiment){
                    $sous_batiments = Sous_batiment::where('ref_batiment', 'LIKE',$batiment->ref_batiment)->get();
                    $la_surface=0;
                    if($batiment->designation_batiment !='شـقة'){
                        $la_surface =$batiment->surface;
                    }else{
                        foreach($sous_batiments as $sous_batiment){
                            if(!empty($sous_batiment->surface_ajuster)){
                                $la_surface = $la_surface + $sous_batiment->surface_ajuster;
                            }else{
                                $la_surface = $la_surface + $sous_batiment->surface;
                            }
                        }
                    }
                    $un_etages=[];
                    $un_etages[]=$batiment;
                    $un_etages[]=$la_surface;
                    $les_etages[$batiment->designation_etage][]=$un_etages;
                }

//                dd(array_map("unserialize", array_unique(array_map("serialize", $les_etages))));
                foreach($les_etages as $index=>$les_etage){
                    foreach ($les_etage as $l){
                        if($l[0]->designation_batiment=='شـقة'){
                            if($l[0]->louer=='1'){
                                $section20->addText(htmlspecialchars("+ ".$l[0]->designation_batiment.' ب'.$index.' مكتراة بمبلغ '.$l[0]->prix_location.' درهم '.(!empty($l[0]->description)?$l[0]->description:'').'.', ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>250,'after'=>480],'indentation'=>['left'=>540,'right'=>950], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
                            }else if($l[0]->fermer=='1'){
                                $section20->addText(htmlspecialchars("+ ".$l[0]->designation_batiment.' ب'.$index.' مغلقة '.(!empty($l[0]->description)?$l[0]->description:'').'.', ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>250,'after'=>480],'indentation'=>['left'=>540,'right'=>950], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
                            }else{
                                if($l[1]==0 || $l[1]==null){
                                    $section20->addText(htmlspecialchars("+ ".$l[0]->designation_batiment.' ب'.$index.(!empty($l[0]->description)?$l[0]->description:'').' . ', ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>250,'after'=>480],'indentation'=>['left'=>540,'right'=>950], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;

                                }else{
                                    $section20->addText(htmlspecialchars("+ ".$l[0]->designation_batiment.' ب'.$index.' مساحتها حوالي '."²m".$l[1].(!empty($l[0]->description)?$l[0]->description:'').' . ', ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>250,'after'=>480],'indentation'=>['left'=>540,'right'=>950], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;

                                }
                            }
                        }else{
                            if($l[0]->louer=='1'){
                                $section20->addText(htmlspecialchars("+ ".$l[0]->designation_batiment.' ب'.$index.' مكتري بمبلغ  '.$l[0]->prix_location.' درهم '.(!empty($l[0]->description)?$l[0]->description:'').'.', ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>250,'after'=>480],'indentation'=>['left'=>540,'right'=>950], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
                            }
                            else if($l[0]->fermer=='1'){
                                $section20->addText(htmlspecialchars("+ ".$l[0]->designation_batiment.' ب'.$index.' مغلق '.(!empty($l[0]->description)?$l[0]->description:'').'.', ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>250,'after'=>480],'indentation'=>['left'=>540,'right'=>950], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
                            }
                            else{
                                if($l[1]==0 || $l[1]==null){
                                    $section20->addText(htmlspecialchars("+ ".$l[0]->designation_batiment.' ب'.$index.(!empty($l[0]->description)?$l[0]->description:'').' . ', ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>250,'after'=>480],'indentation'=>['left'=>540,'right'=>950], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;

                                }else{
                                    $section20->addText(htmlspecialchars("+ ".$l[0]->designation_batiment.' ب'.$index.' مساحته حوالي '."²m".$l[1].(!empty($l[0]->description)?$l[0]->description:'').' . ', ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>250,'after'=>480],'indentation'=>['left'=>540,'right'=>950], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;

                                }
                            }

                        }


                    }
//
                }
            }

            $textp252="-  عدد الأطراف المالكة على الشياع للملك موضوع الخبرة هو $nb_atraf (حسب شهادة الملكية) .";
            $section20->addText(htmlspecialchars($textp252, ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>250,'after'=>480],'indentation'=>['left'=>540,'right'=>640], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
            $section20->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl' => true, 'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right", 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
            $section20->addText(htmlspecialchars(".الأطراف كل على عينية قسمة تقسيمه يمكن لا العقار هذا فإن", ENT_COMPAT, 'UTF-8'), array('bold' => true, 'size' => 16, 'name' => 'arial', 'underline' => 'single'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540], 'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0), 'spacing' => 120, 'lineHeight' => 1));;
        }
        //========================================= page 26 =================================
        $section21 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);

        $section21->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $section21->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $section21->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section21->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section21->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section21->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section21->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section21->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section21->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;

        $firstRowStyle16 = array('bgColor' => 'FEF023','borderSize' => 19);
        $phpWord->addTableStyle('myTable', $tableStyle, $firstRowStyle16);
        $table = $section21->addTable('myTable');
        $table->addRow();
        $c=$table->addCell('7850');
        $c->addText(htmlspecialchars('الإفتتاحي الثمن تحديد-9', ENT_COMPAT, 'UTF-8'), array('size' => 48, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
        $c->addText(htmlspecialchars('العلني بالمزاد العقار لبيع ', ENT_COMPAT, 'UTF-8'), array('size' => 48, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
//========================================= page 27 =================================
        $section22 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);
        $section22->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $tableStyle14 = array(
            'align' => 'right',
            'cellMargin'=>(0|130|0|0)

        );
        $firstRowStyle14 = array();
        $phpWord->addTableStyle('myTable14', $tableStyle14, $firstRowStyle14);
        $table3 = $section22->addTable('myTable14');
        $table3->addRow();
        $table3->addCell('8010')->addText(htmlspecialchars(':السوق في الخبرة موضوع العقار بيع ثمن تحديد - ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial','color'=>'EE0000'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
        $table3->addCell('750',['bgColor' => '#c00000','borderSize' => 21])->addText(htmlspecialchars('7-1', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri','color'=>'FFFFFF'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
        $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation'=>['left'=>20,'right'=>20]));
        $section22->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section22->addText(htmlspecialchars(" من أجل تحديد ثمن بيع الشقة موضوع الخبرة  قمنا بمجموعة من التحريات الميدانية وذلك للتعرف على قيمة الشقق المعروضة للبيع والمجاورة للعقار موضوع الخبرة، من خلال التحريات الميدانية، فإن متوسط ثمن المتر المربع المطلوب لبيع الشقق المجاورة ", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $textrun6 = $section22->addTextRun(array('marginRight'=>70,'marginLeft'=>2500,'align'=>'right','space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));
        $styleFont1 = array('rtl'=>true, 'size'=>16, 'name'=>'arial');
        $styleFont2 = array('bold'=>true, 'size'=>16, 'name'=>'calibri');
        $textrun6->addText(". درهم 9500", $styleFont2);
        $textrun6->addText("للعقار موضوع الخبرة هو:", $styleFont1);
        $section22->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $section22->addText(htmlspecialchars("وبما أن هذه الأثمنة غير نهائية وقابلة للمساومة ، فإننا نقدر ثمن المتر المربع النهائي لبيع", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $textrun6 = $section22->addTextRun(array('marginRight'=>70,'marginLeft'=>2500,'align'=>'right','space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));
        $styleFont1 = array('rtl'=>true, 'size'=>16, 'name'=>'arial');
        $styleFont2 = array('bold'=>true, 'size'=>16, 'name'=>'calibri');
        $styleFont3 = array('bold'=>false, 'size'=>16, 'name'=>'calibri');
        $textrun6->addText("9 500,00 ", $styleFont3);
        $textrun6->addText(" x ", $styleFont3);
        $textrun6->addText(" 0,9", $styleFont3);
        $textrun6->addText(" = ", $styleFont3);
        $textrun6->addText("8550,00", $styleFont2);
        $textrun6->addText("درهم", $styleFont2);

        $textrun6->addText("\t\t", $styleFont2);
        $textrun6->addText("العقار في  :", $styleFont1);
        $section22->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $section22->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $section22->addText(htmlspecialchars("للإشارة فإن نسبة الإستنقاص  10 %المطبقة أعلاه ، قد حددت على ضوء بعض ", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $section22->addText(htmlspecialchars("الدراسات والتحريات المنجزة في هذا المجال .", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));;
        $section22->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $textrun6 = $section22->addTextRun(array('marginRight'=>70,'marginLeft'=>2500,'align'=>'right','space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));
        $styleFont1 = array('rtl'=>true, 'size'=>16, 'name'=>'arial');
//        $styleFont2 = array('bold'=>true, 'size'=>16, 'name'=>'calibri');
//        $styleFont3 = array('bold'=>false, 'size'=>16, 'name'=>'calibri');
        $textrun6->addText("\t\t ", $styleFont1);
        $textrun6->addText(" وبما أن ثمن بيع العقار موضوع الخبرة هو : ", $styleFont1);
        $section22->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $section22->addText(htmlspecialchars("المساحة القابلة للبيع  ×  ثمن بيع المتر المربع", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $section22->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $section22->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $textrun6 = $section22->addTextRun(array('marginRight'=>70,'marginLeft'=>2500,'align'=>'right','space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));
        $styleFont1 = array('rtl'=>true, 'size'=>16, 'name'=>'arial');
//        $styleFont2 = array('bold'=>true, 'size'=>16, 'name'=>'calibri');
        $styleFont3 = array('bold'=>false, 'size'=>16, 'name'=>'calibri');
        $textrun6->addText("\t\t ", $styleFont1);
        $textrun6->addText("40 ²m", $styleFont3);
        $textrun6->addText("وحيث أن المساحة القابلة للبيع للشقة السكنية موضوع الخبرة هي :", $styleFont1);
        $section22->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $textrun6 = $section22->addTextRun(array('marginRight'=>70,'marginLeft'=>2500,'align'=>'right','space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.5));
        $styleFont1 = array('rtl'=>true, 'size'=>16, 'name'=>'arial');
//        $styleFont2 = array('bold'=>true, 'size'=>16, 'name'=>'calibri');
//        $styleFont3 = array('bold'=>false, 'size'=>16, 'name'=>'calibri');
        $textrun6->addText("\t\t ", $styleFont1);
        $textrun6->addText("فإن ثمن بيع الشقة السكنية موضوع الخبرة هو :", $styleFont1);
        $section22->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;

        $textrun6 = $section22->addTextRun(array('marginRight'=>70,'marginLeft'=>2500,'align'=>'center','spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));
        $styleFont1 = array('rtl'=>true, 'size'=>16, 'name'=>'arial');
        $styleFont2 = array('bold'=>true, 'size'=>16, 'name'=>'calibri');
        $styleFont3 = array('bold'=>false, 'size'=>16, 'name'=>'calibri');
        $textrun6->addText("8 550,00 ", $styleFont3);
        $textrun6->addText(" x ", $styleFont3);
        $textrun6->addText(" 40 ²m", $styleFont3);
        $textrun6->addText(" = ", $styleFont3);
        $textrun6->addText("342 000,00", $styleFont2);
        $textrun6->addText("درهم", $styleFont2);
        //========================================= page 28 =================================
        $section23 = $phpWord->addSection(['marginLeft'=>400,'marginRight'=>900,'headerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2), 'footerHeight'=> \PhpOffice\PhpWord\Shared\Converter::inchToTwip(.2)]);
        $section23->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $tableStyle15 = array(
            'align' => 'right',
            'cellMargin'=>(0|130|0|0)

        );
        $firstRowStyle15 = array();
        $phpWord->addTableStyle('myTable15', $tableStyle15, $firstRowStyle15);
        $table3 = $section23->addTable('myTable15');
        $table3->addRow();
        $table3->addCell('8010')->addText(htmlspecialchars(':العلني بالمزاد الخبرة موضوع العقار لبيع الافتتاحي الثمن تحديد - ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial','color'=>'EE0000'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
        $table3->addCell('750',['bgColor' => '#c00000','borderSize' => 21])->addText(htmlspecialchars('7-2', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri','color'=>'FFFFFF'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));
        $table3->addCell('500')->addText(htmlspecialchars(' ', ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'calibri'), array("align" => "center", 'indentation'=>['left'=>20,'right'=>20]));
        $section23->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 3));;
        $section23->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;
        $textrun6 = $section23->addTextRun(array('marginRight'=>70,'marginLeft'=>2500,'align'=>'right','space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));
        $styleFont1 = array('rtl'=>true, 'size'=>16, 'name'=>'arial');
        $styleFont2 = array('bold'=>true, 'size'=>16, 'name'=>'calibri');
        $styleFont3 = array('bold'=>false, 'size'=>16, 'name'=>'calibri');
        $textrun6->addText(" .درهم", $styleFont2);
        $textrun6->addText("342 000,00", $styleFont2);
        $textrun6->addText("بما أن ثمن بيع العقار موضوع الخبرة في السوق هو :", $styleFont1);
        $section23->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
        $section23->addText(htmlspecialchars(": في العلني بالمزاد الخبرة موضوع العقار لبيع الافتتاحي الثمن نقدر فإننا", ENT_COMPAT, 'UTF-8'), array('size' => 18, 'bold' => true, 'name' => 'arial','underline'=>'single'), array("align" => "right",'space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));;
//        $section23->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;

        $textrun6 = $section23->addTextRun(array('marginRight'=>70,'marginLeft'=>2500,'align'=>'center','space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));
        $styleFont1 = array('rtl'=>true, 'size'=>16, 'name'=>'arial');
        $styleFont2 = array('bold'=>true, 'size'=>16, 'name'=>'calibri');
        $styleFont3 = array('bold'=>false, 'size'=>18, 'name'=>'calibri');
        $textrun6->addText("342 000,00 ", $styleFont3);
        $textrun6->addText(" x ", $styleFont3);
        $textrun6->addText(" 0,75", $styleFont3);
        $textrun6->addText(" = ", $styleFont3);
        $textrun6->addText(" 256 500,00 ", $styleFont3);
        $textrun6->addText(" درهم ", $styleFont3);
        $section23->addText(htmlspecialchars("", ENT_COMPAT, 'UTF-8'), array('rtl'=>true,'size' => 16, 'bold' => false, 'name' => 'arial'), array("align" => "right",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1));;

        $textrun6 = $section23->addTextRun(array('marginRight'=>70,'marginLeft'=>2500,'align'=>'right','space'=>['before'=>50,'after'=>480],'indentation'=>['left'=>540,'right'=>540],'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 2));
        $styleFont1 = array('rtl'=>true, 'size'=>18, 'name'=>'arial');
        $styleFont2 = array('bold'=>true, 'size'=>18, 'name'=>'calibri');
        $styleFont3 = array('bold'=>false, 'size'=>18, 'name'=>'calibri');
        $textrun6->addText(" 260 000,00 ", $styleFont2);
        $textrun6->addText(" درهم ", $styleFont2);
        $textrun6->addText("أي ما يقارب : ", $styleFont1);

        //        $c->addText(htmlspecialchars('عينية', ENT_COMPAT, 'UTF-8'), array('size' => 48, 'bold' => true, 'name' => 'arial'), array("align" => "center",'spaceAfter' => \PhpOffice\PhpWord\Shared\Converter::pointToTwip(0),'spacing' => 120,'lineHeight' => 1.15));

        //        dump($nom_avocat_pr);
//        die();





















        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename=report.docx');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save('php://output');
    }
// /************************************       END PRINT REPORT         ************************************************ */

//////////////////////////////////////////////////////////  PPT REPORT  *************************************************************
   public function printPPT(Request $request){

//======================================================== page 1  ===================================




       $objPHPPowerPoint = new PhpPresentation();



       // Modifier taille diapositive Powerpoint - Format A4
       $objPHPPowerPoint->getLayout()->setDocumentLayout(['cx' => 210, 'cy' => 297], true)
           ->setCX(210, DocumentLayout::UNIT_MILLIMETER)
           ->setCY(297, DocumentLayout::UNIT_MILLIMETER);


        // Creer un slide
       $Slide1 = $objPHPPowerPoint->createSlide();

// -------------------------------- Creer l'entête slide -------------------------------

       $this->createHeaderReport($Slide1);

// -------------------------------- Creer Pied slide -------------------------------

       $this->createFooterReport($objPHPPowerPoint,$Slide1);

// -------------------------------- Creer content -------------------------------

       // Create a shape (text)
       $shapeContent = $Slide1->createRichTextShape()
           ->setHeight(300)
           ->setWidth(700)
           ->setOffsetX(0)
           ->setOffsetY(100);



       $textParagraph = $shapeContent->createParagraph();
       $textParagraph->getFont()->setSize(14)->setColor(new Color( 'FF000000' ));

       $shapeContent->getActiveParagraph()->createTextRun("سلام تام بوجود مولانا الإمام")->getFont()->setSize(14)->setColor( new Color( 'FF000000' ));
       $shapeContent->getActiveParagraph()->createBreak();
       $shapeContent->getActiveParagraph()->createBreak();
       $shapeContent->getActiveParagraph()->createTextRun("و بعد سيدي الرئيس")->getFont()->setSize(14)->setColor( new Color( 'FF000000' ));
       $shapeContent->getActiveParagraph()->createBreak();
       $shapeContent->getActiveParagraph()->createBreak();
       $shapeContent->getActiveParagraph()->createTextRun("يشرفني أن أوافي جانبكم بتقرير الخبرة الذي كلفت بإنجازه في الملف المشار إلى مراجعه أعلاه وفق الحكم المؤرخ ")->getFont()->setSize(14)->setColor( new Color( 'FF000000' ));

       $shapeContent->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_RIGHT);




//========================================================================================================
//======================================================== page 2  ========================================
//========================================================================================================


       $Slide2 = $objPHPPowerPoint->createSlide();









// Creer l'entête slide

       $this->createHeaderReport($Slide2);

// Creer Pied slide

     $this->createFooterReport($objPHPPowerPoint,$Slide2);

       // Create a shape (text)




//========================================================================================================
//======================================================== page 5  =======================================
//========================================================================================================

       // Creer new slide
       $Slide5 = $objPHPPowerPoint->createSlide();
       // Creer l'entête slide
       $this->createHeaderReport($Slide5);
       // Creer Pied slide
       $this->createFooterReport($objPHPPowerPoint,$Slide5);

//  Creer shape slide (Content) -------------------------------------------------------------------------

       // Create a shape (TextRun)
       $shapeContent5 = $Slide5->createRichTextShape()
           ->setHeight(970)
           ->setWidth(720)
           ->setOffsetX(0)
           ->setOffsetY(80);

       $textParagraph5 = $shapeContent5->createParagraph();
       $textParagraph5->setLineSpacing(200);
       $textParagraph5->getFont()->setSize(14)->setColor(new Color( 'FF000000' ));
       $shapeContent5->getActiveParagraph()->getAlignment()->setHorizontal( Alignment::HORIZONTAL_RIGHT);

       $shapeContent5->getActiveParagraph()->createTextRun( htmlspecialchars(" : "."عند توصلي بالمأمورية المسندة إلي من طرف المحكمة الموقرة ، قمت بالاجراءات التالية ", ENT_COMPAT, 'UTF-8'), array('rtl' => true))->getFont()->setSize(16)->setColor( new Color( 'FF000000' ));
       $shapeContent5->getActiveParagraph()->createBreak();

       // Creer table pour ajouter le titre

       $text="إستدعاء الأطراف و نوابهم طبقا للفصل ";
       $this->addTitle($Slide5,180,$text);


       $shapeContent5->getActiveParagraph()->createBreak();
       $shapeContent5->getActiveParagraph()->createTextRun(htmlspecialchars(" : "."عملا بالمقتضيات القانونية ، وجهت رسائل الاستدعاء إلى كل من ", ENT_COMPAT, 'UTF-8'), array('rtl' => true))->getFont()->setSize(16)->setColor( new Color( 'FF000000' ));

       // --------------------------------------------------الاطراف المدعية ------------------------------------









// =========================================================== save file ======================================

       $oWriterPPTX = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
       $oWriterPPTX->save(__DIR__ . "/sample.pptx");
       $oWriterODP = IOFactory::createWriter($objPHPPowerPoint, 'ODPresentation');
       $oWriterODP->save(__DIR__ . "/sample.odp");

       echo "printing....";


   }

//////////////////////////////////////////////////////////  END PPT REPORT  *************************************************************

    private function array_doublon($array){

        if (!is_array($array))

            return false;



        $r_valeur = Array();



        $array_unique = array_unique($array);



        if (count($array) - count($array_unique)){

            for ($i=0; $i<count($array); $i++) {

                if (!array_key_exists($i, $array_unique))

                    $r_valeur[] = $array[$i];

            }

        }

        return $r_valeur;

    }



    public function decision(){

        $dossiers=Dossier::all();

        return view('admin.decision',compact('dossiers'));

    }

    public function decisionAdd(Request $request){

        DB::table('dossiers')->where('num_dossier', $request->num_dossier)->update(['decision_jugement' => strip_tags($request->decision_jugement)]);;


        return redirect()->route('dossier.decision')->with('success','تمت الاضافة بنجاح');

    }

    public function getStatistic(){
        $user=Auth::user();
        $personel=Personnel::where('email',$user->email)->first();
        $dossiers=Dossier::where('personnels_id_personnel',$personel->id_personnel)->get();

        return view('admin.statistic',compact('dossiers'));
    }
    public function chart_date(){
        $user=Auth::user();
        $personel=Personnel::where('email',$user->email)->first();
        $dossiers=Dossier::where('personnels_id_personnel',$personel->id_personnel)->get();
        $date=[];
        foreach ($dossiers->all() as $dossier){
            $created_at=explode(' ',$dossier->created_at);
            $m=explode('-',$created_at[0]);
            if($_GET['date']==$m[1]){
                $date[]=$dossier;
            }
        }
        $nd_file=count($date);
        echo $nd_file;
    }
    public function cms(){
        $dossiers=Dossier::where('deposer',0)->paginate(10);
        return view('admin.panel_dossier_report',compact('dossiers'));
    }
    public function cms_next($id){
        return view('admin.index-cms',compact('id'));
    }
    public function manage_report($id){
        $immobiliers=Immobilier::where('jugements_dossiers_num_dossier',$id)->pluck('num_immobilier','num_immobilier');
        return view('admin.report_cms',compact('id','immobiliers'));

    }

    public function addContent(Request $request,$id){
//       dd($request->name);


        $this->validate($request, [
            // check validtion for image or file

            'name[]' => 'image|mimes:jpg,png,jpeg,gif,svg',
        ]);


        $rc=new Reports_contents();
        $rc->titre=$request->titre;
        $rc->contents=$request->contents;
        $rc->num_dossier=$id;
        $rc->save();
        $last=Reports_contents::latest('id')->first();
        if(!empty($request->name)) {
            foreach ($request->name as $imgs) {
                $getimage = time() . rand(0, 10) . '.' . $imgs->getClientOriginalExtension();
                $rci = new Reports_contents_imgs();
                $rci->name = $getimage;
                $rci->id_report_content = $last->id;
                $rci->save();
                $path_img = rtrim(public_path(), 'public') . 'scripts/uploads/pictures/';
                $imgs->move($path_img, $getimage);


//

            }
        }
        return back()->with('success','تم التسجيل');

    }
    public function addImg_immo($id){
        $immobiliers=Immobilier::where('jugements_dossiers_num_dossier',$id)->pluck('num_immobilier','num_immobilier');

        return view('admin.img-immo',compact('id','immobiliers'));
    }
    public function addImg_immo_add(Request $request,$id){
        $this->validate($request, [
            'name' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);
        $getimage = time() . rand(0, 10) . '.' . $request->name->getClientOriginalExtension();
        $immobilier=Immobilier::where('num_immobilier',$request->num_immo)->where('jugements_dossiers_num_dossier',$id)->first();
        $immobilier->img_immo = $getimage;
        $immobilier->save();
        $path_img = rtrim(public_path(), 'public') . 'scripts/uploads/pictures/';
        $request->name->move($path_img, $getimage);
        return back()->with('success','تم التسجيل');


    }

}