package helper;

import br.framework.classes.DataBase.DataBaseProperties;
import br.framework.classes.helpers.Types;

public class ConfigManager {


    public ConfigManager() {
        super();
    }


    private void loadProperties(DataBaseProperties properties, String dbName) {
        String dataBaseName = "mmdb";
        String dataBaseType = "Postgres";
        String host = "localhost";
        Integer port = 5432;
        String user = "postgres";
        String tnsName = "";
        String password = "12345";
        Integer numConnections = 20;


        properties.setDataBaseName(dataBaseName);
        Types.DataBase Banco = Types.DataBase.valueOf(dataBaseType);
        properties.setMaxConnections(numConnections);
        properties.setHostAdress(host);
        properties.setUserName(user);
        properties.setTnsName(tnsName);
        properties.setPassword(password);
        properties.setServerType(Banco);
        properties.setDriverName("org.postgresql.Driver");
        properties.setPort(port);

    }

    public void loadConfig(Configuration configuration){
        DataBaseProperties properties = configuration.getDataBase();
        this.loadProperties(properties, "db");
        configuration.setDataBase(properties);
        configuration.setIsLoaded(true);
    }
}
