package controllers.web;

import br.framework.interfaces.IConnection;
import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.node.BaseJsonNode;
import com.fasterxml.jackson.databind.node.ObjectNode;
import dao.CategoriaDao;
import helper.ConnectionFactory;
import helper.ResultJson;
import model.entity.Categoria;
import play.mvc.Result;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import static play.mvc.Controller.request;
import static play.mvc.Controller.session;
import static play.mvc.Results.ok;

public class CategoriaController {
   /* public Result getCategorias(){
        BaseJsonNode result = (ObjectNode) ResultJson.makeOk("Dados ataulizar preço etiqueta atualizados com sucesso");
        return ok(result);
    }*/

   /*
    public Result getCategorias(){
        BaseJsonNode result = (ObjectNode) ResultJson.makeOk("Dados das categorias pesquisados com sucesso");
        IConnection connection = null;
        try {
            connection = ConnectionFactory.newConnection();
            DepartamentoDao dao = new DepartamentoDaoImpl(connection);
            List<Departamento> departamentos = dao.getDepartamentos(lastID);
            result = dao.serializeToJson(departamentos, (ObjectNode) result);
        } catch (SQLException e) {
            logger.error("Exception caught", e);
        } catch (Exception e) {
            logger.error("Exception caught", e);
            result = ResultJson.makeError(e, "Erro ao pesquisar departamentos");
        } finally {
            if (connection != null) {
                connection.close();
            }
        }
        return ok(result);
    }
    */

    public Result insertCategoria() {
        BaseJsonNode result = (ObjectNode) ResultJson.makeOk("Dados da categoria inseridos com sucesso");
        IConnection connection = null;
        try {
            List<String> errors = new ArrayList<>();
            JsonNode categoriaJson = request().body().asJson();
            connection = ConnectionFactory.newConnection();
            CategoriaDao dao = new CategoriaDao(connection);
            Categoria categoria = dao.jsonToEntity((ObjectNode) categoriaJson);

            /*
            dao.insert(departamento, errors, usuario);
            if (errors.size()>0) {
                result = ResultJson.makeError(errors);
            } else {
                ResultJson.setToResponse(result, "codigo", departamento.getCodigo().getValue());
            }
            */
        } catch (SQLException e) {
            //logger.error("Exception caught", e);
        } catch (Exception e) {
            //logger.error("Exception caught", e);
            result = ResultJson.makeError(e, "Erro ao inserir categoria");
        } finally {
            if (connection != null) {
                connection.close();
            }
        }
        return ok(result);
    }
}
