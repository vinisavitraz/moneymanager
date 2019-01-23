package dao;

import br.framework.classes.DataBase.EntityManager;
import br.framework.classes.DataBase.Transaction;
import br.framework.interfaces.IConnection;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.node.ObjectNode;
import com.google.common.base.Strings;
import exceptions.JsonParseException;
import model.entity.Categoria;
import play.libs.Json;

import java.util.ArrayList;
import java.util.List;

public class CategoriaDao {
    private IConnection connection;
    private EntityManager manager;
    private Boolean autoCommit;
    private Transaction transaction;

    public CategoriaDao(IConnection connection) {
        super();
        this.autoCommit = true;
        this.transaction = null;
        this.connection = connection;
        this.manager = new EntityManager(this.connection);
    }

    public ObjectNode serializeToJson(Categoria categoria) {
        ObjectNode node = Json.newObject();
        node.put("id", categoria.getId().getValue());
        node.put("descricao", categoria.getDescricao().getValue());
        node.put("status", categoria.getStatus().getValue());
        return node;
    }


    public Categoria jsonToEntity(ObjectNode json) throws JsonParseException {
        List<String> errors = new ArrayList<String>();
        Categoria categoria = new Categoria();

        JsonNode node = json.get("descricao");
        if (node==null) {
            errors.add("Não foi localizado o campo 'descricao'");
        } else {
            String descricao = node.asText();
            categoria.getDescricao().setValue(descricao);
        }

        node = json.get("status");
        if (node!=null) {
            String status = node.asText();
            if (Strings.isNullOrEmpty(status)) {
                status = "N";
            }
            categoria.getStatus().setValue(status);
        }

        if (errors.size()>0) {
            throw new JsonParseException("Falha na estrutura dos dados fornecidos", errors);
        }
        return categoria;
    }

}
