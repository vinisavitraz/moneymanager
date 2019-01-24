package dao;

import br.framework.classes.DataBase.EntityManager;
import br.framework.classes.DataBase.SequenceProperties;
import br.framework.classes.DataBase.Transaction;
import br.framework.classes.helpers.Types;
import br.framework.exceptions.ReadSequenceValueException;
import br.framework.interfaces.IConnection;
import br.framework.interfaces.IEntityClass;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.node.ArrayNode;
import com.fasterxml.jackson.databind.node.ObjectNode;
import exceptions.JsonParseException;
import model.entity.Usuario;
import play.libs.Json;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

public class UsuarioDao {
    private IConnection connection;
    private EntityManager manager;

    public UsuarioDao(IConnection connection) {
        super();
        this.connection = connection;
        this.manager = new EntityManager(this.connection);
    }

    public ObjectNode serializeToJson(List<Usuario> usuarios, ObjectNode resultNode){
        ArrayNode arrayNode = resultNode.putArray("usuarios");
        for (Usuario usuario: usuarios) {
            ObjectNode node = this.serializeToJson(usuario);
            arrayNode.add(node);
        }
        return resultNode;
    }

    public ObjectNode serializeToJson(Usuario usuario) {
        ObjectNode node = Json.newObject();
        node.put("id", usuario.getId().getValue());
        node.put("nome", usuario.getNome().getValue());
        node.put("email", usuario.getEmail().getValue());
        node.put("usuario", usuario.getUsuario().getValue());
        node.put("senha", usuario.getSenha().getValue());
        node.put("status", usuario.getStatus().getValue());
        node.put("ativo", usuario.getAtivo().getValue());
        return node;
    }


    public Usuario jsonToEntity(ObjectNode json) throws JsonParseException {
        List<String> errors = new ArrayList<>();
        Usuario usuario = new Usuario();

        JsonNode node = json.get("nome");
        if (node==null) {
            errors.add("Não foi localizado o campo 'nome'");
        } else {
            String nome = node.asText();
            usuario.getNome().setValue(nome);
        }

        node = json.get("email");
        if (node==null) {
            errors.add("Não foi localizado o campo 'email'");
        } else {
            String email = node.asText();
            usuario.getEmail().setValue(email);
        }

        node = json.get("usuario");
        if (node==null) {
            errors.add("Não foi localizado o campo 'usuario'");
        } else {
            String usr = node.asText();
            usuario.getUsuario().setValue(usr);
        }

        node = json.get("senha");
        if (node==null) {
            errors.add("Não foi localizado o campo 'senha'");
        } else {
            String senha = node.asText();
            usuario.getSenha().setValue(senha);
        }


        if (errors.size()>0) {
            throw new JsonParseException("Falha na estrutura dos dados fornecidos", errors);
        }
        return usuario;
    }

    public void insert(Usuario usuario, List<String> errors)throws Exception {
        if (this.exists(usuario)) {
            errors.add("Usuario já existe na base de dados");
        } else {
            Long id = this.getNextId();
            usuario.getId().setValue(id.intValue());
            usuario.setOperation(Types.Operations.Insert);
        }
        Transaction transaction = null;
        try {
            if (errors.size() == 0) {
                transaction = this.connection.getTransaction();
                transaction.addEntity(usuario);
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
            errors.add("Ocorreu erro interno na tentativa de gravação do usuário. " + e.getMessage());
        }
    }

    public List<Usuario> getUsuarios() throws Exception{
        EntityManager manager = new EntityManager(this.connection);
        List<Usuario> result = new ArrayList<>();

        String SQL = "select * from usuario ";
        SQL +=" where usu_status = 'N' order by usu_id ";

        List<IEntityClass> records = manager.query(SQL, Usuario.class);

        for (IEntityClass record: records) {
            result.add((Usuario) record);
        }

        return result;
    }

    public List<Usuario> getUsuario(Integer id) throws Exception{
        EntityManager manager = new EntityManager(this.connection);
        List<Usuario> result = new ArrayList<>();

        String SQL = "select * from usuario ";
        SQL +=" where usu_id = '" + id.toString() + "' and usu_status = 'N' order by usu_id ";

        List<IEntityClass> records = manager.query(SQL, Usuario.class);

        for (IEntityClass record: records) {
            result.add((Usuario) record);
        }

        return result;
    }

    public Long getNextId() throws ReadSequenceValueException {
        Long codigo;
        SequenceProperties seq = new SequenceProperties("seq_usu_id", 0, 1);
        codigo = this.connection.getNextSequenceValue(seq);
        return codigo;
    }

    private Boolean exists(Usuario usuario) throws SQLException {
        String SQL = "select usu_id from Usuario where usu_id = " + usuario.getId().getValue().toString();
        ResultSet Q = this.connection.queryFactory(SQL);
        Boolean exists = Q.next();
        Q.close();
        return exists;
    }
}
