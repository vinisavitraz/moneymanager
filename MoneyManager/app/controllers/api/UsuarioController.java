package controllers.api;

import br.framework.interfaces.IConnection;
import com.fasterxml.jackson.databind.node.BaseJsonNode;
import com.fasterxml.jackson.databind.node.ObjectNode;
import dao.CategoriaDao;
import dao.UsuarioDao;
import helper.ConnectionFactory;
import helper.ResultJson;
import model.entity.Usuario;
import play.mvc.Result;

import java.sql.SQLException;
import java.util.List;

import static play.mvc.Results.ok;

public class UsuarioController {

    public Result getUsuarios(){
        BaseJsonNode result = (ObjectNode) ResultJson.makeOk("Dados dos usuarios pesquisados com sucesso");
        IConnection connection = null;
        try {
            connection = ConnectionFactory.newConnection();
            UsuarioDao dao = new UsuarioDao(connection);
            List<Usuario> usuarios = dao.getUsuarios();
            result = dao.serializeToJson(usuarios, (ObjectNode) result);
        } catch (SQLException e) {
            result = ResultJson.makeError(e, "Erro ao pesquisar usuarios");
        } catch (Exception e) {
            result = ResultJson.makeError(e, "Erro ao pesquisar usuarios");
        } finally {
            if (connection != null) {
                connection.close();
            }
        }
        return ok(result);
    }

    public Result getUsuario(Integer id){
        BaseJsonNode result = (ObjectNode) ResultJson.makeOk("Dados do usuario pesquisados com sucesso");
        IConnection connection = null;
        try {
            connection = ConnectionFactory.newConnection();
            UsuarioDao dao = new UsuarioDao(connection);
            List<Usuario> usuario = dao.getUsuario(id);
            result = dao.serializeToJson(usuario, (ObjectNode) result);
        } catch (SQLException e) {
            result = ResultJson.makeError(e, "Erro ao pesquisar usuario com o id " + id);
        } catch (Exception e) {
            result = ResultJson.makeError(e, "Erro ao pesquisar usuario com o id " + id);
        } finally {
            if (connection != null) {
                connection.close();
            }
        }
        return ok(result);
    }

    public Result getUsuarioAutenticado(){
        return getUsuario(1);
    }
}
