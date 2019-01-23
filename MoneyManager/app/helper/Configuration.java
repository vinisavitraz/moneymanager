package helper;

import br.framework.classes.DataBase.DataBaseProperties;

public class Configuration {

    private static Configuration instance;
    private DataBaseProperties dataBase;
    private Boolean loaded;

    public Configuration() {
        this.dataBase = new DataBaseProperties("","","","");
        this.dataBase.setMaxConnections(20);
        this.setIsLoaded(false);
    }

    public DataBaseProperties getDataBase() {
        return dataBase;
    }

    public void setDataBase(DataBaseProperties dataBase) {
        this.dataBase = dataBase;
    }

    public synchronized static Configuration getInstance() {
        if (Configuration.instance==null) {
            Configuration.instance = new Configuration();
        }
        return Configuration.instance;
    }

    public synchronized static void build() {
        if (Configuration.instance==null) {
            Configuration.instance = new Configuration();
        }
        ConfigManager manager = new ConfigManager();
        manager.loadConfig(Configuration.instance);
    }

    public Boolean isLoaded() {
        return this.loaded;
    }

    public void setIsLoaded(Boolean loaded) {
        this.loaded = loaded;
    }

}
