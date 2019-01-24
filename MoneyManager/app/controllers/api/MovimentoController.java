package controllers.api;

import com.fasterxml.jackson.databind.node.BaseJsonNode;
import com.fasterxml.jackson.databind.node.ObjectNode;
import helper.ResultJson;
import play.mvc.Controller;
import play.mvc.Result;

public class MovimentoController extends Controller {

    public Result teste(){
        BaseJsonNode result = (ObjectNode) ResultJson.makeOk("Dados ataulizar preço etiqueta atualizados com sucesso");

        /*
        List<String> errors = new ArrayList<>();
        IConnection connection = null;
        try {
            connection = ConnectionFactory.newConnection();
            //TarefaProdutoDao dao = new TarefaProdutoDaoImpl(connection);
            JsonNode tarefaProdutoJson = request().body().asJson();
            TarefaProdutoDao dao = new TarefaProdutoDaoImpl(connection);
            List<TarefaProduto> listaTarefasProduto = new ArrayList<>();
            EtiquetaPendente etqp = dao.jsonToEntityEtqs((ObjectNode) tarefaProdutoJson.get("EtiquetasPendente"));
            //TarefaProduto tarefas = dao.jsonToEntity((ObjectNode) tarefaProdutoJson);

            /*Unidade unidade = new Unidade();
            for (int i = 0; i < tarefaProdutoJson.size(); i++){
                TarefaProduto tarefaProduto = dao.jsonToEntity((ObjectNode) tarefaProdutoJson.get(i));
                listaTarefasProduto.add(tarefaProduto);
                unidade.getCodigo().setValue(tarefaProduto.getUnid_codigo().getValue());
            }

            Unidade unidade = new Unidade();
            unidade.getCodigo().setValue(etqp.getUnid_codigo());
            model.business.Evento eventoWorker = new model.business.Evento(connection);
            model.entity.Evento evento = eventoWorker.criarEvento(Tipos.TipoEvento.ATUALIZA_PRECO_ETIQUETA, unidade.getCodigo().getValue(), 9999, "Sitema" );

            WebServiceDao webServiceDao = new WebServiceFlexDao(connection, null);
            // Config config = new Config();
            // ConfigDao dao = new ConfigDaoImpl(connection);
            // webServiceDao.login(dao.);

            /*Sincronizacoes sincronizacoes = dao.jsonToEntity((ObjectNode) sincronizacoesJson.get("sincronizacoes"));

            dao.inicializaSincronizacao(sincronizacoes, errors);


            EtiquetaService etiquetaService = new EtiquetaService(connection, new WebServiceFlexDao(connection, null), unidade);
            etiquetaService.atualizarPrecoEtiquetaERP(listaTarefasProduto, unidade, evento, webServiceDao );


            if (errors.size()>0) {
                result = ResultJson.makeError(errors);
            }
        } catch (Exception e) {
            logger.error("Exception caught", e);
            for (int i = 0; i < errors.size(); i++){
                ResultJson.setToResponse(result, "Erros ", errors.get(i).toString());
            }
        } finally {
            if (connection != null) {
                connection.close();
            }
        }
        */
        return ok(result);
    }
}
