<?php
namespace Framework\Actions;
use Framework\Router;
use Framework\Validator\Validator;
use Framework\Session\FlashService;
use Psr\Http\Message\ResponseInterface;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class CrudAction 
{
    private $renderer;
    private $table;
    private $router;
    private $flash;
    use RouterAwareAction;

    protected $viewPath;
    protected $routePrefix;
    protected $message = [
        'create' => 'Element creer',
        'edit' => 'Element modifier',
    ];

    public function __construct(
        RendererInterface $renderer,
        $table,
        Router $router,
        FlashService $flash){
        $this->renderer = $renderer;
        $this->table = $table;
        $this->router = $router;
        $this->flash = $flash;

     }

    public function index(ServerRequestInterface $request): string {
        $this->renderer->addGlobal('viewPath', $this->viewPath);
        $this->renderer->addGlobal('routePrefix', $this->routePrefix);

        $page = $request->getQueryParams();
        $items = $this->table->findPaginated(5, $page['p'] ?? 1);
        return $this->renderer->render($this->viewPath . '/index', compact('items'));
    }

    public function edit(ServerRequestInterface $request)
    {
        $this->renderer->addGlobal('viewPath', $this->viewPath);
        $this->renderer->addGlobal('routePrefix', $this->routePrefix);

        $item = $this->table->find($request->getAttribute('id'));

        $errors = '';


        if($request->getMethod() == 'POST'){
            $params = array_merge($request->getParsedBody(), $request->getUploadedFiles());

            $validator = $this->getValidator($request);
            if($validator->isValid())
            {
                $this->table->update($item->id, $this->getParams($request));
                $this->flash->success($this->message['edit']);    
                return $this->redirect($this->routePrefix.'.index');
            }
            $errors = $validator->getErrors();
        }

        $data = $this->sendDataToView(compact('item', 'errors'));

        return $this->renderer->render($this->viewPath . '/edit', $data);
    }

    protected function sendDataToView(array $params) : array
    {
        return $params;
    }

    public function create(ServerRequestInterface $request)
    {
        $this->renderer->addGlobal('viewPath', $this->viewPath);
        $this->renderer->addGlobal('routePrefix', $this->routePrefix);

        if($request->getMethod() == 'POST'){
            $params = $this->getParams($request);

            $validator = $this->getValidator($request);
            if($validator->isValid())
            {
                $this->table->create($params);
                $this->flash->success($this->message['create']);    
                return $this->redirect($this->routePrefix.'.index');
            }
            $errors = $validator->getErrors();
        }

        $data = $this->sendDataToView(compact('item', 'errors'));

        return $this->renderer->render($this->viewPath . '/create', $data);
        }

    public function delete(ServerRequestInterface $request) : ResponseInterface
    {
        $id = $request->getAttribute('id');
        $this->table->delete($id);
        return $this->redirect($this->routePrefix.'.index');
    }

    protected function getParams(ServerRequestInterface $request) : array
    {
        return array_filter($request->getParsedBody(), function($key){
            return in_array($key, []);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function getValidator(ServerRequestInterface $request) : Validator
    {
        return (new Validator(array_merge(
            $request->getParsedBody(), 
            $request->getUploadedFiles()
        )));
    }
}