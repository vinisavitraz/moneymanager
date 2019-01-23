import br.framework.interfaces.IConnection;
import helper.Configuration;
import helper.ConnectionFactory;

import dbdefinitions.ScriptDDL;

import javax.inject.Inject;
import javax.inject.Singleton;


@Singleton
public class OnStartup {

    @Inject
    public OnStartup(){
        initDb();
    }

    private void initDb(){
        Configuration.build();
        Configuration configuration = Configuration.getInstance();
        ConnectionFactory.build();

        IConnection connectionDDL = null;
        IConnection connection = null;

        Boolean hasError = false;

        try {
//            Sentry.init("https://c4fed1d2f37b44a09bfff65fd43c5306@sentry.io/1221741");
            connectionDDL = ConnectionFactory.newNoPooledConnection();
            ScriptDDL scriptDDL = new ScriptDDL(connectionDDL);
            scriptDDL.execute();
            connection=ConnectionFactory.newConnection();
        } catch (Exception e) {
            e.printStackTrace();
            hasError = true;
        } finally {
            if (connectionDDL != null) {
                connectionDDL.close();
            }
        }
        /*
        if (!hasError) {
            //Iniciar threads
            /*
            if (configuration.getSynchronize()) {
                this.erpSync = new ErpSync(connection);
                this.erpSync.run();
            } else {
                this.runner = new TaskRunner(connection);
                this.runner.run();
            }

        }
        */
    }


}
