package dbdefinitions;

import br.framework.classes.DataBase.PostgreSQL.PostgresCommandDDLExecuter;
import br.framework.classes.DataBase.PostgreSQL.PostgresConnection;
import br.framework.classes.DataBase.SequenceProperties;
import br.framework.classes.helpers.Types;
import br.framework.interfaces.ICommandDDLExecuter;
import br.framework.interfaces.IConnection;

import java.sql.SQLException;

public class ScriptDDL {
    private IConnection connection;

    public ScriptDDL(IConnection connection) {
        this.connection = connection;
    }

    public void execute() throws SQLException, ClassNotFoundException {
        if (connection.connect()) {
            ICommandDDLExecuter script = null;
            if (connection.getDataBaseType() == Types.DataBase.Postgres) {
                script = new PostgresCommandDDLExecuter((PostgresConnection) connection, "model.entity");
            }
            if (script != null) {

                SequenceProperties seq = new SequenceProperties("seq_cat_id", 0, 1);
                script.addSequence(seq);

                seq = new SequenceProperties("seq_usu_id", 0, 1);
                script.addSequence(seq);

                seq = new SequenceProperties("seq_mov_id", 0, 1);
                script.addSequence(seq);

                seq = new SequenceProperties("seq_rec_id", 0, 1);
                script.addSequence(seq);

                seq = new SequenceProperties("seq_cart_id", 0, 1);
                script.addSequence(seq);

                seq = new SequenceProperties("seq_op_id", 0, 1);
                script.addSequence(seq);

                try {
                    script.run(Boolean.TRUE);
                } catch (Exception e) {
                    e.printStackTrace();
                }

                try {
                    // script.createIndex("aude_idx1", "auditoriaestoque", "aude_codigo, aude_unid_codigo, aude_tarp_codigo");
                    script.createIndex("cat_idx1", "categoria", "cat_id");
                    script.createIndex("usu_idx1", "usuario", "usu_id");
                    script.createIndex("mov_idx1", "movimento", "mov_id");
                    script.createIndex("rec_idx1", "recorrente", "rec_id");
                    script.createIndex("cart_idx1", "cartao", "cart_id");
                    script.createIndex("op_idx1", "operacao", "op_id");


                } catch (Exception e) {
                    e.printStackTrace();
                }
            }
        }
    }
}
