package helper;

import br.framework.classes.DataBase.DataBaseProperties;
import br.framework.classes.DataBase.PostgreSQL.PostgresConnection;
import br.framework.classes.helpers.Types;
import br.framework.interfaces.IConnection;

import javax.sql.DataSource;
import org.postgresql.ds.PGSimpleDataSource;
import java.sql.Connection;
import java.sql.SQLException;


public class ConnectionFactory {
    private static ConnectionFactory instance;
    private DataSource dataSource;
    private Configuration configuration = Configuration.getInstance();
    private String connString;


    public ConnectionFactory()  {
        this.buildAttributes();
    }

    private void buildAttributes() {
        DataBaseProperties properties;

        properties = this.configuration.getDataBase();
        Types.DataBase Banco = properties.getServerType();
        DataSource dataSource = null;
        if (Banco == Types.DataBase.Postgres) {
            properties.setDriverName("org.postgresql.Driver");
            try {

                PGSimpleDataSource ds = new PGSimpleDataSource();
                ds.setDatabaseName(properties.getDataBaseName());
                ds.setPassword(properties.getPassword());
                ds.setPortNumber(properties.getPort());
                ds.setServerName(properties.getHostAdress());
                ds.setUser(properties.getUserName());
                ds.setLoginTimeout(10);
                dataSource = ds;
            } catch (Exception e) {
                // O setLoginTimeout do Driver do postrgresql por algum movivo contem um throws do SQLException
                // porem, nenhuma exceção é gerada dentro do método
            }
        }

        this.dataSource = dataSource;

    }

    public static IConnection newNoPooledConnection() {
        DataBaseProperties properties;
        properties = ConnectionFactory.getInstance().configuration.getDataBase();
        Types.DataBase Banco = properties.getServerType();
        DataSource dataSource = null;
        IConnection connection = null;
        if (Banco == Types.DataBase.Postgres) {
            properties.setDriverName("org.postgresql.Driver");
            connection = new PostgresConnection(properties);
        }
        return connection;
    }


    public synchronized static ConnectionFactory getInstance() {
        if (ConnectionFactory.instance == null) {
            ConnectionFactory.instance = new ConnectionFactory();
        }
        return ConnectionFactory.instance;
    }

    public synchronized static void build() {
        if (ConnectionFactory.instance == null) {
            ConnectionFactory.instance = new ConnectionFactory();
        }
    }

    public synchronized  static IConnection newConnection() throws SQLException {
        ConnectionFactory manager = ConnectionFactory.getInstance();
        return manager.factory();
    }

    public synchronized static void ClearInstance() {
        ConnectionFactory.instance = null;
        System.gc();
    }


    public synchronized IConnection factory() throws SQLException {
        IConnection result = null;
        DataSource dataSource = this.dataSource;
        DataBaseProperties properties = this.configuration.getDataBase();

        Connection conn = dataSource.getConnection();
        if (properties.getServerType() == Types.DataBase.Postgres) {
            PostgresConnection psConnection = new PostgresConnection(properties, conn);
            try {
                psConnection.executeDDLCommand("set client_encoding='utf8'");
            } catch (Exception e) {
               e.printStackTrace();
            }
            result = psConnection;
        }
        return result;
    }

    public String getConnString() {
        return connString;
    }

    public void setConnString(String connString) {
        this.connString = connString;
    }

}
