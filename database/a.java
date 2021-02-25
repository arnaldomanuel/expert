package pt.tecnico.script;

import java.util.List;

import mz.co.transcom.fenix.integ.FenixTranscomInteg;
import net.sourceforge.fenixedu.domain.candidacyProcess.IndividualCandidacy;
import net.sourceforge.fenixedu.domain.student.Registration;
import net.sourceforge.fenixedu.domain.student.Student;

import org.fenixedu.bennu.scheduler.custom.CustomTask;

import pt.ist.fenixframework.Atomic;
import pt.ist.fenixframework.Atomic.TxMode;

//Script para gerar Referência definitiva de estudantes Transitados do Fenix Antigo para o Novo no ITC 2019
public class GenerateStudentsReference extends CustomTask {
    @Override
    @Atomic(mode = TxMode.WRITE)
    public void runTask() throws Exception {

        taskLog();

        gererateRef();

    }

    private void gererateRef() {
        int[] studentID =
                {11641,11640,11639,11638,11637};
    	 String[] studentreference =
             {"20116370133","20116380124","20116390115","20116400106","20116410194"};
        taskLog("==== Starting Student's Reference Generation =====");
        for (int i = 0; i < studentID.length; i++) {
			
//		}
//        for (int id : studentID) {
            try {
                taskLog("Starting Student " + studentID[i]);
                List<Registration> students = Registration.readByNumber(studentID[i]);
                if (students.isEmpty()) {
                    continue;
                }
                Registration registration = students.get(0);

                taskLog("Student Name " + registration.getName());
                Student student = registration.getStudent();
                
                
                IndividualCandidacy candidacy = registration.getIndividualCandidacy();
                student.setCandidacyReference(studentreference[i]);
                taskLog("Candidacy refs.: " + student.getCandidacyReference());
                
////                /*Criar cliente-candidato no Primavera/
                FenixTranscomInteg.getPrimaveraService().createClient(candidacy);

                //Valida a a criacao do cliente-candidato 
                FenixTranscomInteg.getPrimaveraService().updateClient(candidacy);

                //Cria a matricula do candidato
                FenixTranscomInteg.getPrimaveraService().updateClient(registration);

                //Finaliza o candidato para estudante, oferecendo a referencia definitiva
                FenixTranscomInteg.getPrimaveraService().updateClientToRegisted(candidacy);
                
                student.setFinalReference(studentreference[i]);
                taskLog("Final refs.: " + student.getFinalReference());

            } catch (ArrayIndexOutOfBoundsException e) {
                taskLog("Couldn't generate ref for Student" + studentID[i]);
                continue;
            }
        }
    }
}