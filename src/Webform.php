<?php

namespace Proloweb\WebformClient;

use GuzzleHttp\Exception\GuzzleException;
use Proloweb\WebformClient\Entity\Form;
use Symfony\Component\HttpFoundation\Request;

class Webform
{
    private Api $api;

    private string $crmInstanceId;

    protected Request $request;

    private array $options;

    private ?Form $form;

    /**
     * @param string $crmInstanceId
     * @param array $options
     */
    public function __construct(string $crmInstanceId, array $options = [])
    {
        $this->crmInstanceId = $crmInstanceId;
        $this->options = $options;

        $this->api = new Api();
        $this->request = Request::createFromGlobals();
    }

    /**
     * @throws WebformException
     * @throws GuzzleException
     */
    public function init()
    {
        if (empty($this->crmInstanceId)) {
            throw new WebformException(
                WebformException::CRM_INSTANCE_ID_EMPTY_MESSAGE,
                WebformException::CRM_INSTANCE_ID_EMPTY_CODE
            );
        }

        $slug = $this->getSlug();

        if (empty($slug)) {
            return;
        }

        // step 1 : retrieve form from slug :
        $this->form = $this->getForm($slug);

        if ($this->form instanceof Form) {
            if ($this->request->isMethod('POST')) {
                $this->submitFormResponse($this->crmInstanceId, $slug);
                exit;
            }
        } else {
            // form not found
            throw new WebformException(
                WebformException::CRM_INSTANCE_ID_EMPTY_MESSAGE,
                WebformException::CRM_INSTANCE_ID_EMPTY_CODE
            );
        }
    }

    public function getSlug(): string
    {
        return $this->request->get('slug');
    }

    public function getJsonData(): string
    {
        return $this->form->json_data;
    }

    public function showTitle(): string
    {
        if ($this->hasForm()) {
            return $this->form->title;
        } else {
            return 'My WebForm';
        }
    }

    public function hasForm(): bool
    {
        return $this->form instanceof Form;
    }

    /**
     * @param string $slug
     * @return Form|null
     * @throws GuzzleException
     */
    private function getForm(string $slug):?Form
    {
        $response = $this->api->getWebformBySlug($this->crmInstanceId, $slug);

        $formData = $response->toArray();

        if (isset($formData['slug']) && $formData['slug'] === $slug && !empty($formData['json_data'])) {
            $formEntity = new Form();
            $formEntity->title = $formData['title'] ?? '';
            $formEntity->start_date = $formData['start_date'] ?? '';
            $formEntity->due_date = $formData['due_date'] ?? '';
            $formEntity->json_data = $formData['json_data'];

            return $formEntity;
        }

        return null;
    }

    /**
     * @param string $instanceId
     * @param string $slug
     * @return void
     * @throws GuzzleException
     */
    private function submitFormResponse(string $instanceId, string $slug): void
    {
        $this->api->sendFormResponse(
            $instanceId,
            $slug,
            $this->request->getContent(),
            $this->request->getClientIp()
        );
    }
}
