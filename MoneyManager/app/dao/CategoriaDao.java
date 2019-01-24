package dao;

import br.framework.classes.DataBase.EntityManager;
import br.framework.classes.DataBase.SequenceProperties;
import br.framework.classes.DataBase.Transaction;
import br.framework.classes.helpers.Types;
import br.framework.exceptions.ReadSequenceValueException;
import br.framework.interfaces.IConnection;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.node.ObjectNode;
import com.google.common.base.Strings;
import exceptions.JsonParseException;
import model.entity.Categoria;
import play.libs.Json;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

public class CategoriaDao {
    private IConnection connection;
    private EntityManager manager;

    public CategoriaDao(IConnection connection) {
        super();
        this.connection = connection;
        this.manager = new EntityManager(this.connection);
    }

    public ObjectNode serializeToJson(Categoria categoria) {
        ObjectNode node = Json.newObject();
        node.put("id", categoria.getId().getValue());
        node.put("descricao", categoria.getDescricao().getValue());
        node.put("status", categoria.getStatus().getValue());
        node.put("ativo", categoria.getAtivo().getValue());
        return node;
    }


    public Categoria jsonToEntity(ObjectNode json) throws JsonParseException {
        List<String> errors = new ArrayList<>();
        Categoria categoria = new Categoria();

        JsonNode node = json.get("descricao");
        if (node==null) {
            errors.add("Não foi localizado o campo 'descricao'");
        } else {
            String descricao = node.asText();
            categoria.getDescricao().setValue(descricao);
        }

        if (errors.size()>0) {
            throw new JsonParseException("Falha na estrutura dos dados fornecidos", errors);
        }
        return categoria;
    }

    public void insert(Categoria categoria, List<String> errors)throws Exception {
        if (this.exists(categoria)) {
            errors.add("Categoria já existe na base de dados");
        } else {
            Long id = this.getNextId();
            categoria.getId().setValue(id.intValue());
            categoria.setOperation(Types.Operations.Insert);
        }
        Transaction transaction = null;
        try {
            if (errors.size() == 0) {
                transaction = this.connection.getTransaction();
                transaction.addEntity(categoria);
                transaction.commit();

            }
        }catch (Exception e) {
            try {
                if (transaction!=null) {
                    transaction.rollback();
                }
            } catch (SQLException e1) {
                e1.printStackTrace();
            }
            errors.add("Ocorreu erro interno na tentativa de gravação da categoria. " + e.getMessage());
        }
    }

    public Long getNextId() throws ReadSequenceValueException {
        Long codigo;
        SequenceProperties seq = new SequenceProperties("seq_cat_id", 0, 1);
        codigo = this.connection.getNextSequenceValue(seq);
        return codigo;
    }

    private Boolean exists(Categoria categoria) throws SQLException {
        String SQL = "select cat_id from Categoria where cat_id = " + categoria.getId().getValue().toString();
        ResultSet Q = this.connection.queryFactory(SQL);
        Boolean exists = Q.next();
        Q.close();
        return exists;
    }

}
