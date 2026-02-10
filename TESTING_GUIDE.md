# 🧪 Guide for AI Testing & System Correction

This guide is intended for AI agents (like Jules) to ensure a robust testing environment and clear steps for system verification/correction.

## 🚀 Commands

### Running All Tests
```bash
php artisan test
```

### Running Specific Suites
```bash
# Feature tests only
php artisan test --testsuite=Feature

# Unit tests only
php artisan test --testsuite=Unit

# Module tests only
php artisan test --testsuite=Modules
```

### Running Tests for a Specific Module
```bash
php artisan test Modules/NameOfModule/tests
```

## 🛠️ Testing Environment
- **Database**: SQLITE in-memory (`:memory:`) is used for all tests to ensure speed and isolation.
- **Environment**: Automatically set to `testing` via `phpunit.xml`.
- **Mocking**: Use Laravel's built-in mocking for external services (WebPush, Gerencianet, etc.).

## 📝 Best Practices for AI Agents

1. **Always Verify Before Fixing**: Run the relevant test before making any changes to confirm the issue.
2. **Modular Tests**: When working on a module, create tests inside `Modules/{ModuleName}/tests`.
3. **Database Migrations**: Tests should use the `Illuminate\Foundation\Testing\RefreshDatabase` trait.
4. **Naming Conventions**: Use descriptive test names in Portuguese (e.g., `test_usuario_nao_pode_acessar_sem_permissao`).
5. **Real-time Verification**: For JS/Livewire features, use Dusk or component testing where applicable.

## 🎯 Coverage Target
Ensure all Core and Module features have at least:
- **Unit Tests**: For critical business logic in Models and Services.
- **Feature Tests**: For main Controller endpoints and Route access control.
